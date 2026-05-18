<?php

namespace Sharenjoy\NoahDomain;

use Illuminate\Database\Eloquent\Relations\Relation;
use Sharenjoy\NoahDomain\Models\Cms\Carousel;
use Sharenjoy\NoahDomain\Models\Cms\Category;
use Sharenjoy\NoahDomain\Models\Cms\Faq;
use Sharenjoy\NoahDomain\Models\Cms\Menu;
use Sharenjoy\NoahDomain\Models\Cms\Post;
use Sharenjoy\NoahDomain\Models\Cms\Role;
use Sharenjoy\NoahDomain\Models\Cms\StaticPage;
use Sharenjoy\NoahDomain\Models\Cms\Tag;
use Sharenjoy\NoahDomain\Models\Shop\Address;
use Sharenjoy\NoahDomain\Models\Shop\BaseOrder;
use Sharenjoy\NoahDomain\Models\Shop\BasePromo;
use Sharenjoy\NoahDomain\Models\Shop\Brand;
use Sharenjoy\NoahDomain\Models\Shop\CoinMutation;
use Sharenjoy\NoahDomain\Models\Shop\Country;
use Sharenjoy\NoahDomain\Models\Shop\CouponPromo;
use Sharenjoy\NoahDomain\Models\Shop\Currency;
use Sharenjoy\NoahDomain\Models\Shop\DeliveredOrder;
use Sharenjoy\NoahDomain\Models\Shop\Giftproduct;
use Sharenjoy\NoahDomain\Models\Shop\Invoice;
use Sharenjoy\NoahDomain\Models\Shop\InvoicePrice;
use Sharenjoy\NoahDomain\Models\Shop\IssuedOrder;
use Sharenjoy\NoahDomain\Models\Shop\MinQuantityPromo;
use Sharenjoy\NoahDomain\Models\Shop\MinSpendPromo;
use Sharenjoy\NoahDomain\Models\Shop\NewOrder;
use Sharenjoy\NoahDomain\Models\Shop\Objective;
use Sharenjoy\NoahDomain\Models\Shop\Order;
use Sharenjoy\NoahDomain\Models\Shop\OrderItem;
use Sharenjoy\NoahDomain\Models\Shop\OrderShipment;
use Sharenjoy\NoahDomain\Models\Shop\Product;
use Sharenjoy\NoahDomain\Models\Shop\ProductSpecification;
use Sharenjoy\NoahDomain\Models\Shop\Promo;
use Sharenjoy\NoahDomain\Models\Shop\ShippableOrder;
use Sharenjoy\NoahDomain\Models\Shop\ShippedOrder;
use Sharenjoy\NoahDomain\Models\Shop\StockMutation;
use Sharenjoy\NoahDomain\Models\Shop\Survey\Answer;
use Sharenjoy\NoahDomain\Models\Shop\Survey\Entry;
use Sharenjoy\NoahDomain\Models\Shop\Survey\Question;
use Sharenjoy\NoahDomain\Models\Shop\Survey\Section;
use Sharenjoy\NoahDomain\Models\Shop\Survey\Survey;
use Sharenjoy\NoahDomain\Models\Shop\Transaction;
use Sharenjoy\NoahDomain\Models\Shop\User;
use Sharenjoy\NoahDomain\Models\Shop\UserCoupon;
use Sharenjoy\NoahDomain\Models\Shop\UserCouponStatus;
use Sharenjoy\NoahDomain\Models\Shop\UserLevel;
use Sharenjoy\NoahDomain\Models\Shop\UserLevelStatus;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NoahDomainServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('noah-domain')
            ->hasConfigFile([
                'twaddress',
            ]);
    }

    public function bootingPackage(): void
    {
        Relation::enforceMorphMap($this->morphMap());
    }

    /**
     * @return array<string, class-string>
     */
    protected function morphMap(): array
    {
        $models = [
            Address::class,
            Answer::class,
            BaseOrder::class,
            BasePromo::class,
            Brand::class,
            Carousel::class,
            Faq::class,
            Category::class,
            CoinMutation::class,
            Country::class,
            CouponPromo::class,
            Currency::class,
            DeliveredOrder::class,
            Entry::class,
            Giftproduct::class,
            Invoice::class,
            InvoicePrice::class,
            IssuedOrder::class,
            Menu::class,
            MinQuantityPromo::class,
            MinSpendPromo::class,
            NewOrder::class,
            Objective::class,
            Order::class,
            OrderItem::class,
            OrderShipment::class,
            Post::class,
            Product::class,
            ProductSpecification::class,
            Promo::class,
            Question::class,
            Role::class,
            Section::class,
            ShippableOrder::class,
            ShippedOrder::class,
            StaticPage::class,
            StockMutation::class,
            Survey::class,
            Tag::class,
            Transaction::class,
            User::class,
            UserCoupon::class,
            UserCouponStatus::class,
            UserLevel::class,
            UserLevelStatus::class,
        ];

        return collect($models)->mapWithKeys(
            fn(string $model): array => [class_basename($model) => $model],
        )->all();
    }
}
