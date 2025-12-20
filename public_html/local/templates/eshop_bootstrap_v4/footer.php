<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>


</div><!--end row-->

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
    <a class="see-balls_wrapp" href=<? SITE_DIR ?>"tablitsa-ballov/">
        <div class="see-balls">Посмотреть мои баллы

            <svg width="50px" height="50px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none"
                 stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="miter">
                <polyline points="13 17 18 12 13 7"></polyline>
                <line x1="6" y1="12" x2="18" y2="12"></line>
            </svg>

        </div>
    </a>
    <? $APPLICATION->IncludeComponent(
            "bitrix:advertising.banner",
            "bootstrap_v4",
            array(
                    "COMPONENT_TEMPLATE" => "bootstrap_v4",
                    "TYPE" => "MAIN",
                    "NOINDEX" => "Y",
                    "QUANTITY" => "5",
                    "BS_EFFECT" => "slide",
                    "BS_CYCLING" => "N",
                    "BS_WRAP" => "Y",
                    "BS_PAUSE" => "Y",
                    "BS_KEYBOARD" => "Y",
                    "BS_ARROW_NAV" => "Y",
                    "BS_BULLET_NAV" => "Y",
                    "BS_HIDE_FOR_TABLETS" => "N",
                    "BS_HIDE_FOR_PHONES" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "HEIGHT" => 500,
                    "DEFAULT_TEMPLATE" => "jssor"
            ),
            false,
            array(
                    "ACTIVE_COMPONENT" => "Y"
            )
    ); ?>

<?php endif; ?>
<?php // форма обратной связи?>
<div id="feedback">
    <? $APPLICATION->IncludeComponent(
	"sporina:forms.feedback", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"FORM_NAME" => "Форма обратной связи",
		"SUCCESS_MESSAGE" => "Спасибо! Ваша заявка отправлена.",
		"ERROR_MESSAGE" => "Ошибка при отправке. Попробуйте позже.",
		"USE_POPUP" => "N",
		"SHOW_NAME" => "Y",
		"SHOW_PHONE" => "Y",
		"SHOW_EMAIL" => "Y",
		"SHOW_MESSAGE" => "Y",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "PHONE",
			2 => "EMAIL",
		),
		"FORM_BACKGROUND_COLOR" => "#ffffff",
		"FIELD_BACKGROUND_COLOR" => "#ffffff",
		"BUTTON_BACKGROUND_COLOR" => "#E30613 ",
		"BUTTON_TEXT_COLOR" => "#ffffff",
		"BORDER_COLOR" => "#dddddd",
		"TEXT_COLOR" => "#333333",
		"VALIDATE_EMAIL" => "Y",
		"VALIDATE_PHONE" => "Y",
		"ENABLE_CONSENT" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	),
	false
); ?>
</div>
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
</div> <!-- //bx-wrapper -->


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