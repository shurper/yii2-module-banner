<?php
/**
 * Created by PhpStorm.
 * User: shurper
 * Date: 19.06.2018
 * Time: 13:16
 */

namespace shurper\banner\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

class AdsPopPlaceFilter extends Model
{
    public $filter;

    /**@inheritdoc
     * @return array
     */
    public function rules(): array
    {
        return [
            ['filter', 'string', 'max' => 255]
        ];
    }

    /**
     * @return ActiveDataProvider
     * @throws BadRequestHttpException
     */
    public function dataProvider(): ActiveDataProvider
    {
        if (!$this->validate())
            throw new BadRequestHttpException('Model validation error');

        return new ActiveDataProvider([
            'query' => AdsPopupPlace::find()->andFilterWhere(['LIKE', 'title', $this->filter])
        ]);
    }
}