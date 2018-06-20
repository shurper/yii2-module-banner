<?php

namespace floor12\banner\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ads_place".
 *
 * @property int $id
 * @property string $title Название площадки
 * @property int $desktop_width Ширина (дексктоп)
 * @property int $desktop_height Высота (дексктоп)
 * @property int $mobile_width Ширина (мобильный)
 * @property int $mobile_height Высота (мобильный)
 * @property int $status Выключить
 * @property int $slider Активировать слайдер
 * @property AdsBanner[] $banners Связанные баннеры
 * @property AdsBanner[] $bannersActive Активные баннеры
 *
 */
class AdsPlace extends ActiveRecord
{

    const STATUS_ACTIVE = 0;
    const STATUS_DISABLED = 1;

    const SLIDER_DISABLED = 0;
    const SLIDER_ENABLED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'ads_place';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['title', 'desktop_width', 'desktop_height'], 'required'],
            [['desktop_width', 'desktop_height', 'mobile_width', 'mobile_height', 'status', 'slider'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /** Связь площадки с баннерами
     * @return ActiveQuery
     */
    public function getBanners(): AdsBannerQuery
    {
        return $this
            ->hasMany(AdsBanner::class, ['id' => 'banner_id'])
            ->viaTable('ads_place_banner', ['place_id' => 'id'])
            ->inverseOf('places');
    }


    /** Активные баннеры.
     *  Проверяем, активен ли баннер, есть если у него выставлены даты - сравниваем с текущей датой
     * @return ActiveQuery
     */
    public function getBannersActive(): AdsBannerQuery
    {
        return $this->getBanners()->active();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => 'Название площадки',
            'desktop_width' => 'Ширина (дексктоп)',
            'desktop_height' => 'Высота (дексктоп)',
            'mobile_width' => 'Ширина (мобильный)',
            'mobile_height' => 'Высота (мобильный)',
            'status' => 'Выключить',
            'slider' => 'Активировать слайдер'
        ];
    }

    /** Если не задана ширина мобильного баннера, копируем туда значения десктопного варианта.
     * @return bool
     */
    public function beforeValidate(): bool
    {
        if (!$this->mobile_width)
            $this->mobile_width = $this->desktop_width;

        if (!$this->mobile_height)
            $this->mobile_height = $this->desktop_height;

        return parent::beforeValidate();
    }

    /** Удобно использовать возможность привести объект к строке
     * @return string
     */
    public function __toString(): string
    {
        return $this->title;
    }

}
