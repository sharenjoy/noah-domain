<?php

namespace Sharenjoy\NoahDomain\Models\Shop\Survey;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sharenjoy\NoahDomain\Casts\Survey\SeparatedByCommaAndSpace;
use Sharenjoy\NoahDomain\Models\Cms\Traits\CommonModelTrait;
use Sharenjoy\NoahDomain\Models\Cms\Traits\HasMediaLibrary;
use Sharenjoy\NoahDomain\Models\Shop\Survey\Entry;
use Sharenjoy\NoahDomain\Models\Shop\Survey\Question;

class Answer extends Model
{
    use CommonModelTrait;
    use SoftDeletes;
    use HasMediaLibrary;

    protected $table = 'srv_answers';

    protected $casts = [
        'value' => SeparatedByCommaAndSpace::class,
    ];

    public $translatable = [];

    protected array $sort = [
        'created_at' => 'desc',
    ];

    /**
     * The entry the answer belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }

    /**
     * The question the answer belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
