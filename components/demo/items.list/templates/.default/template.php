<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$this->setFrameMode(true);

?>

<h2><?= $arResult['SECTION_NAME'] ?></h2>
<?php if (count($arResult['ITEMS'])) {?>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($arResult['ITEMS'] as $item) { ?>
                <div class="col">
                    <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><a href="<?= $item['URL']; ?>"><?= $item['NAME'] ?></a></h5>
                            <p class="card-text"><?= TruncateText($item['TEXT'], 100) ?></p>
                        </div>
                    </div>
                </div>
        <?php } ?>
    </div>
<?php } ?>
