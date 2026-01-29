<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>


</div><!--end row content-wrapp-->

</div><!--end .container.bx-content-section-->
</div><!--end .workarea-->

<?
$curPage = $APPLICATION->GetCurPage(true);

if ($curPage == SITE_DIR . "index.php"): ?>
<? $APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        array(
                "AREA_FILE_SHOW" => "file",
                "PATH" => SITE_DIR . "include/accordion-faq.php"
        ),
        false
); ?>

<a id="feedback" class="see-balls_wrapp" href=<? SITE_DIR ?>"tablitsa-ballov/">
    <div class="see-balls">Посмотреть мои баллы

        <svg width="50px" height="50px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none"
             stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="miter">
            <polyline points="13 17 18 12 13 7"></polyline>
            <line x1="6" y1="12" x2="18" y2="12"></line>
        </svg>

    </div>
</a>
<div class="container">
    <?php else: ?>
    <div id="feedback" class="container">
        <?php endif; ?>
        <? $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR . "include/curUserBallyBottom.php"
                ),
                false
        ); ?>
    </div>


    <div>
        <?php if ($curPage == SITE_DIR . "index.php"): ?>
            <? $APPLICATION->IncludeComponent(
                    "star:owlcarousel",
                    ".default",
                    array(
                            "AUTO" => "false",
                            "CONTROLS" => "true",
                            "COUNT" => "14",
                            "COUNT_SLIDES" => "3",
                            "DATA_TYPE" => "IBLOCK",
                            "FOLDER" => "/upload/",
                            "IBLOCK_ID" => "22",
                            "IBLOCK_TYPE" => "slider",
                            "IMAGE" => "PREVIEW",
                            "JQUERY" => "N",
                            "LINK" => "N",
                            "LOOP" => "true",
                            "MARGIN" => "20",
                            "NEW_WINDOW" => "N",
                            "PAGER" => "true",
                            "PROPERTY_CODE" => "",
                            "SORT_BY1" => "SORT",
                            "SORT_ORDER1" => "DESC",
                            "COMPONENT_TEMPLATE" => ".default"
                    ),
                    false
            ); ?>

        <?php endif; ?>
    </div>
    <br>
    <footer class="bx-footer">


        <div class="bx-footer-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-lg-6 order-lg-2 order-1 mb-4 mb-lg-0">
                        <h6 class="bx-block-title text-light">
                            <? $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    array(
                                            "AREA_FILE_SHOW" => "file",
                                            "PATH" => SITE_DIR . "include/about_title.php"
                                    ),
                                    false
                            ); ?>
                        </h6>

                    </div>
                    <div class="col-sm-6 col-lg-6 order-lg-2 order-1 mb-4 mb-lg-0 lab-align-right">
                        <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                array(
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => SITE_DIR . "include/socnet_footer.php",
                                        "AREA_FILE_RECURSIVE" => "N",
                                        "EDIT_MODE" => "html",
                                ),
                                false,
                                array('HIDE_ICONS' => 'Y')
                        ); ?>

                    </div>

                </div>
            </div>
        </div>
        <div class="bx-footer-section py-2 bg-secondary">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 bx-up">
                        <a href="javascript:void(0)" data-role="eshopUpButton" class="text-white"><i
                                    class="fa fa-caret-up"></i> <?= GetMessage("FOOTER_UP_BUTTON") ?></a>
                    </div>
                    <div class="col-sm-6 text-white text-right">
                        <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_DIR . "include/copyright.php"
                        ), false); ?>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="col d-sm-none">
        <? $APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "bootstrap_v4", array(
                "PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
                "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
                "SHOW_PERSONAL_LINK" => "N",
                "SHOW_NUM_PRODUCTS" => "Y",
                "SHOW_TOTAL_PRICE" => "Y",
                "SHOW_PRODUCTS" => "N",
                "POSITION_FIXED" => "Y",
                "POSITION_HORIZONTAL" => "center",
                "POSITION_VERTICAL" => "bottom",
                "SHOW_AUTHOR" => "Y",
                "PATH_TO_REGISTER" => SITE_DIR . "login/",
                "PATH_TO_PROFILE" => SITE_DIR . "personal/"
        ),
                false,
                array()
        ); ?>
    </div>
    <!-- //bx-wrapper -->


    <script>
        BX.ready(function () {
            var upButton = document.querySelector('[data-role="eshopUpButton"]');
            BX.bind(upButton, "click", function () {
                var windowScroll = BX.GetWindowScrollPos();
                (new BX.easing({
                    duration: 500,
                    start: {scroll: windowScroll.scrollTop},
                    finish: {scroll: 0},
                    transition: BX.easing.makeEaseOut(BX.easing.transitions.quart),
                    step: function (state) {
                        window.scrollTo(0, state.scroll);
                    },
                    complete: function () {
                    }
                })).animate();
            })
        });
    </script>
    </body>
    </html>