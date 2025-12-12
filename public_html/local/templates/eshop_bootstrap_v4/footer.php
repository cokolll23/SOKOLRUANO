<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>




			</div><!--end row-->

		</div><!--end .container.bx-content-section-->
	</div><!--end .workarea-->

	<footer class="bx-footer">

		<div class="bx-footer-section py-5">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 col-lg-3 order-lg-2 order-1 mb-4 mb-lg-0">
						<h6 class="bx-block-title text-light">
							<? $APPLICATION->IncludeComponent(
								"bitrix:main.include",
								"",
								array(
									"AREA_FILE_SHOW" => "file",
									"PATH" => SITE_DIR."include/about_title.php"
								),
								false
							);?>
						</h6>

					</div>
					<div class="col-sm-6 col-lg-3 order-lg-2 order-1 mb-4 mb-lg-0">
                        <?$APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                Array(
                                        "AREA_FILE_SHOW" => "file",
                                        "PATH" => SITE_DIR."include/socnet_footer.php",
                                        "AREA_FILE_RECURSIVE" => "N",
                                        "EDIT_MODE" => "html",
                                ),
                                false,
                                Array('HIDE_ICONS' => 'Y')
                        );?>

					</div>

				</div>
			</div>
		</div>
		<div class="bx-footer-section py-2 bg-secondary">
				<div class="container">
					<div class="row">
						<div class="col-sm-6 bx-up">
							<a href="javascript:void(0)" data-role="eshopUpButton" class="text-white"><i class="fa fa-caret-up"></i> <?=GetMessage("FOOTER_UP_BUTTON")?></a>
						</div>
						<div class="col-sm-6 text-white text-right">
							<? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => SITE_DIR."include/copyright.php"
							), false);?>
						</div>
					</div>
				</div>
			</div>
	</footer>
	<div class="col d-sm-none">
		<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "bootstrap_v4", array(
				"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
				"PATH_TO_PERSONAL" => SITE_DIR."personal/",
				"SHOW_PERSONAL_LINK" => "N",
				"SHOW_NUM_PRODUCTS" => "Y",
				"SHOW_TOTAL_PRICE" => "Y",
				"SHOW_PRODUCTS" => "N",
				"POSITION_FIXED" =>"Y",
				"POSITION_HORIZONTAL" => "center",
				"POSITION_VERTICAL" => "bottom",
				"SHOW_AUTHOR" => "Y",
				"PATH_TO_REGISTER" => SITE_DIR."login/",
				"PATH_TO_PROFILE" => SITE_DIR."personal/"
			),
			false,
			array()
		);?>
	</div>
</div> <!-- //bx-wrapper -->


<script>
	BX.ready(function(){
		var upButton = document.querySelector('[data-role="eshopUpButton"]');
		BX.bind(upButton, "click", function(){
			var windowScroll = BX.GetWindowScrollPos();
			(new BX.easing({
				duration : 500,
				start : { scroll : windowScroll.scrollTop },
				finish : { scroll : 0 },
				transition : BX.easing.makeEaseOut(BX.easing.transitions.quart),
				step : function(state){
					window.scrollTo(0, state.scroll);
				},
				complete: function() {
				}
			})).animate();
		})
	});
</script>
</body>
</html>