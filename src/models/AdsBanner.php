<?php

namespace floor12\banner\models;

use \backend\components\ManyToManyBehavior;
use \floor12\files\components\FileBehaviour;
use floor12\files\models\File;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ads_banner".
 *
 * @property int $id
 * @property int $status Выключить
 * @property string $title Название баннера
 * @property string $show_start Начало показа
 * @property string $show_end Окончание показа
 * @property string $href Ссылка
 * @property int $views Показы
 * @property int $clicks Клики
 * @property array $place_ids Массив айдишников связанных площадок
 * @property AdsPlace[] $places Связанные площадки
 * @property File $file_desktop
 * @property File $file_mobile
 *
 */
class AdsBanner extends ActiveRecord
{

    const STATUS_ACTIVE = 0;
    const STATUS_DISABLED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'ads_banner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['status', 'views', 'clicks'], 'integer'],
            [['title'], 'required'],
            [['show_start', 'show_end'], 'safe'],
            [['title', 'href'], 'string', 'max' => 255],
            ['file_desktop', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxFiles' => 1],
            ['file_mobile', 'file', 'extensions' => ['jpg', 'jpeg', 'png', 'gif'], 'maxFiles' => 1],
            ['file_desktop', 'required'],
            [['place_ids'], 'each', 'rule' => ['integer']],
            ['href', 'url', 'defaultScheme' => 'https']

        ];
    }

    /** Связь баннера с площадками
     * @return ActiveQuery
     */
    public function getPlaces(): ActiveQuery
    {
        return $this
            ->hasMany(AdsPlace::class, ['id' => 'place_id'])
            ->viaTable('ads_place_banner', ['banner_id' => 'id'])
            ->inverseOf('banners');
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'status' => 'Выключить',
            'title' => 'Название баннера',
            'show_start' => 'Начало показа',
            'show_end' => 'Окончание показа',
            'href' => 'Ссылка',
            'views' => 'Показы',
            'clicks' => 'Клики',
            'file_desktop' => 'Изображение (декстоп)',
            'file_mobile' => 'Изображение (мобильный)',
            'place_ids' => 'Связанные площадки'
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'files' => [
                'class' => FileBehaviour::class,
                'attributes' => ['file_desktop', 'file_mobile']
            ],
            'ManyToManyBehavior' => [
                'class' => ManyToManyBehavior::class,
                'relations' => [
                    'place_ids' => 'places',
                ],
            ],
        ];
    }

    /** Удобно использовать возможность привести объект к строке
     * @return string
     */
    public function __toString(): string
    {
        return $this->title;
    }

    /** Приводим дату к формату MySQL
     * @return bool
     */
    public function beforeValidate(): bool
    {
        if ($this->show_start)
            $this->show_start = date("Y-m-d", strtotime($this->show_start));

        if ($this->show_end)
            $this->show_end = date("Y-m-d", strtotime($this->show_end));

        return parent::beforeValidate();
    }

    /** После поиска из базы приводим дату к человеческому формату
     */
    public function afterFind()
    {
        if ($this->show_start)
            $this->show_start = date("d.m.Y", strtotime($this->show_start));

        if ($this->show_end)
            $this->show_end = date("d.m.Y", strtotime($this->show_end));

        parent::afterFind();
    }


    /**
     * {@inheritdoc}
     * @return AdsBannerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AdsBannerQuery(get_called_class());
    }

    /** Увеличиваем счетчик просмотров
     *  Ради 2х строчек кода не буду выносить этот функционал в отдельный класс, хотя может в будущем.
     * @return bool
     */
    public function increaseViews(): bool
    {
        $this->views++;
        return $this->save(false);
    }

    /** Увеличиваем счетчик кликов
     * @return bool
     */
    public function increaseClicks(): bool
    {
        $this->clicks++;
        return $this->save(false);
    }


}
