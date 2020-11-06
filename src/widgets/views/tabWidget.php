<?php
/**
 * Created by PhpStorm.
 * User: shurper
 * Date: 26.11.2016
 * Time: 18:11
 *
 * @var $linkPostfix string
 * @var $item array
 */

?>

<li<?php if (isset($item['active']) && $item['active']) echo " class='active'"; ?>>
    <a href="<?= $item['href'] ?><?= $linkPostfix ? "/" . $linkPostfix : NULL ?>">
        <?= $item['name'] ?>
    </a>
</li>
