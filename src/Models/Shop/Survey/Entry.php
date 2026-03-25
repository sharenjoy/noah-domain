<?php

namespace Sharenjoy\NoahDomain\Models\Shop\Survey;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Sharenjoy\NoahDomain\Enums\SurveyEntryStatus;
use Sharenjoy\NoahDomain\Exceptions\Survey\GuestEntriesNotAllowedException;
use Sharenjoy\NoahDomain\Exceptions\Survey\MaxEntriesPerUserLimitExceeded;
use Sharenjoy\NoahDomain\Models\Shop\Survey\Answer;
use Sharenjoy\NoahDomain\Models\Shop\Survey\Question;
use Sharenjoy\NoahDomain\Models\Shop\Survey\Survey;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Spatie\ModelStatus\HasStatuses;

class Entry extends Model
{
    use CommonModelTrait;
    use SoftDeletes;
    use HasStatuses;

    protected $table = 'srv_entries';

    protected $casts = [];

    protected $appends = ['status'];

    public $translatable = [];

    protected array $sort = [
        'created_at' => 'desc',
    ];

    /**
     * Boot the entry.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        //Prevent submission of entries that don't meet the parent survey's constraints.
        static::creating(function (self $entry) {
            $entry->validateParticipant();
            $entry->validateMaxEntryPerUserRequirement();
        });

        //Automatically set the status to 'Established' when created a new entry.
        static::created(function (self $entry) {
            if (! $entry->status) {
                $entry->setStatus(SurveyEntryStatus::Established->value);
            }
        });
    }

    public function isValidStatus(string $name, ?string $reason = null): bool
    {
        if (! array_key_exists($name, SurveyEntryStatus::options())) {
            return false;
        }

        return true;
    }

    /**
     * The answers within the entry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * The survey the entry belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    /**
     * The participant that the entry belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participant()
    {
        return $this->belongsTo(User::class, 'participant_id');
    }

    public function getStatusAttribute(): ?string
    {
        if ($this->status === null) {
            return null;
        }

        return $this->status();
    }

    /**
     * Set the survey the entry belongs to.
     *
     * @param  Survey  $survey
     * @return $this
     */
    public function for(Survey $survey)
    {
        $this->survey()->associate($survey);

        return $this;
    }

    /**
     * Set the participant who the entry belongs to.
     *
     * @param  Model|null  $model
     * @return $this
     */
    public function by(?Model $model = null)
    {
        $this->participant()->associate($model);

        return $this;
    }

    /**
     * Create an entry from an array.
     *
     * @param  array  $values
     * @return $this
     */
    public function fromArray(array $values)
    {
        foreach ($values as $key => $value) {
            if ($value === null) {
                continue;
            }

            $answer_class = new Answer;

            $this->answers->add($answer_class::make([
                'question_id' => substr($key, 1),
                'entry_id' => $this->id,
                'value' => $value,
            ]));
        }

        return $this;
    }

    /**
     * The answer for a given question.
     *
     * @param  Question  $question
     * @return mixed|null
     */
    public function answerFor(Question $question)
    {
        $answer = $this->answers()->where('question_id', $question->id)->first();

        return isset($answer) ? $answer->value : null;
    }

    /**
     * Save the model and all of its relationships.
     * Ensure the answers are automatically linked to the entry.
     *
     * @return bool
     */
    public function push()
    {
        $this->save();

        foreach ($this->answers as $answer) {
            $answer->entry_id = $this->id;
        }

        return parent::push();
    }

    /**
     * Validate participant's legibility.
     *
     * @throws GuestEntriesNotAllowedException
     */
    public function validateParticipant()
    {
        if ($this->survey->acceptsGuestEntries()) {
            return;
        }

        if ($this->participant_id !== null) {
            return;
        }

        throw new GuestEntriesNotAllowedException();
    }

    /**
     * Validate if entry exceeds the survey's
     * max entry per participant limit.
     *
     * @throws MaxEntriesPerUserLimitExceeded
     */
    public function validateMaxEntryPerUserRequirement()
    {
        $limit = $this->survey->limitPerParticipant();

        if ($limit === null) {
            return;
        }

        $count = static::where('participant_id', $this->participant_id)
            ->where('survey_id', $this->survey->id)
            ->count();

        if ($count >= $limit) {
            throw new MaxEntriesPerUserLimitExceeded();
        }
    }
}
