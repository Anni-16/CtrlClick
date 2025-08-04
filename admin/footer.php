		</div>

		</div>

		<footer style="padding-left:500px; padding-top:10px;">
			<p class="clr-white" style="font-size:18px;">Ctrl Click ©
				<script>
					document.write(new Date().getFullYear());
				</script> All Rights Reserved | <a href="https://firstpointwebdesign.com" target="_blank"><span style="color:green;"> Website Design</span></a> - By - <a href="https://firstpointwebdesign.com" target="_blank" style="color: green;">First Point Web Design</a>
			</p>

		</footer>

		<script src="js/jquery-2.2.4.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>
		<script src="js/select2.full.min.js"></script>
		<script src="js/jquery.inputmask.js"></script>
		<script src="js/jquery.inputmask.date.extensions.js"></script>
		<script src="js/jquery.inputmask.extensions.js"></script>
		<script src="js/moment.min.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>
		<script src="js/icheck.min.js"></script>
		<script src="js/fastclick.js"></script>
		<script src="js/jquery.sparkline.min.js"></script>
		<script src="js/jquery.slimscroll.min.js"></script>
		<script src="js/jquery.fancybox.pack.js"></script>
		<script src="js/app.min.js"></script>
		<script src="js/jscolor.js"></script>
		<script src="js/on-off-switch.js"></script>
		<script src="js/on-off-switch-onload.js"></script>
		<script src="js/clipboard.min.js"></script>
		<script src="js/demo.js"></script>
		<script src="js/summernote.js"></script>

		<script>
			$(document).ready(function() {
				$('#editor1').summernote({
					height: 300
				});
				$('#editor2').summernote({
					height: 300
				});
				$('#editor3').summernote({
					height: 300
				});
				$('#editor4').summernote({
					height: 300
				});
				$('#editor5').summernote({
					height: 300
				});
				$('#editor6').summernote({
					height: 300
				});
				$('#editor7').summernote({
					height: 300
				});
				$('#editor8').summernote({
					height: 300
				});
			});
			// get location name by filteration
			$("#state-cat").on('change', function() {
				var id = $(this).val();
				var dataString = 'id=' + id;
				$.ajax({
					type: "POST",
					url: "get-city.php",
					data: dataString,
					cache: false,
					success: function(html) {
						$("#city-cat").html(html);
					}
				});
			});
			$("#city-cat").on('change', function() {
				var id = $(this).val();
				var dataString = 'id=' + id;
				$.ajax({
					type: "POST",
					url: "get-area.php",
					data: dataString,
					cache: false,
					success: function(html) {
						$("#area-cat").html(html);
					}
				});
			});

			// Get Packages name by filtering
			$("#plan-cat").on('change', function() {
				let id = $(this).val();

				$.ajax({
					type: "POST",
					url: "get-plan-sub-categories.php",
					data: {
						id: id
					},
					cache: false,
					success: function(html) {
						$("#plan-sub-cat").html(html);
					},
					error: function(xhr, status, error) {
						console.error("Error fetching sub categories:", error);
					}
				});
			});
			// Step 1: Load Plan Types when Sub Category is selected
			$("#plan-sub-cat").on('change', function() {
				let id = $(this).val();

				$.ajax({
					type: "POST",
					url: "get-plan-type-list.php", // <-- This should return <option> list for #plan-type
					data: {
						id: id
					},
					cache: false,
					success: function(html) {
						$("#plan-type").html(html);
					},
					error: function(xhr, status, error) {
						console.error("Error fetching plan types:", error);
					}
				});
			});

			// Step 2: When Plan Type changes, fill Price, Duration, and Package Title
			$("#plan-type").on("change", function() {
				let id = $(this).val();
				let selectedText = $(this).find("option:selected").text();

				$("input[name='package_title']").val(selectedText); // Auto-fill Package Title

				if (id !== "") {
					$.ajax({
						type: "POST",
						url: "get-plan-type-details.php", // <-- This should return JSON with success, price, duration
						data: {
							id: id
						},
						dataType: "json",
						success: function(data) {
							if (data.success) {
								$("#plan-price").val(data.plan_type_price);
								$("#plan-duration").val(data.plan_type_duration);
							} else {
								$("#plan-price").val('');
								$("#plan-duration").val('');
							}
						},
						error: function(xhr, status, error) {
							console.error("Error fetching plan type details:", error);
						}
					});
				} else {
					$("#plan-price").val('');
					$("#plan-duration").val('');
				}
			});
		</script>

		<script>
			$(function() {

				//Initialize Select2 Elements
				$(".select2").select2();

				//Datemask dd/mm/yyyy
				$("#datemask").inputmask("dd-mm-yyyy", {
					"placeholder": "dd-mm-yyyy"
				});
				//Datemask2 mm/dd/yyyy
				$("#datemask2").inputmask("mm-dd-yyyy", {
					"placeholder": "mm-dd-yyyy"
				});
				//Money Euro
				$("[data-mask]").inputmask();

				//Date picker
				$('#datepicker').datepicker({
					autoclose: true,
					format: 'dd-mm-yyyy',
					todayBtn: 'linked',
				});

				$('#datepicker1').datepicker({
					autoclose: true,
					format: 'dd-mm-yyyy',
					todayBtn: 'linked',
				});

				//iCheck for checkbox and radio inputs
				$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
					checkboxClass: 'icheckbox_minimal-blue',
					radioClass: 'iradio_minimal-blue'
				});
				//Red color scheme for iCheck
				$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
					checkboxClass: 'icheckbox_minimal-red',
					radioClass: 'iradio_minimal-red'
				});
				//Flat red color scheme for iCheck
				$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
					checkboxClass: 'icheckbox_flat-green',
					radioClass: 'iradio_flat-green'
				});



				$("#example1").DataTable();
				$('#example2').DataTable({
					"paging": true,
					"lengthChange": false,
					"searching": false,
					"ordering": true,
					"info": true,
					"autoWidth": false
				});

				$('#confirm-delete').on('show.bs.modal', function(e) {
					$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
				});

				$('#confirm-approve').on('show.bs.modal', function(e) {
					$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
				});

			});

			function confirmDelete() {
				return confirm("Are you sure want to delete this data?");
			}

			function confirmActive() {
				return confirm("Are you sure want to Active?");
			}

			function confirmInactive() {
				return confirm("Are you sure want to Inactive?");
			}
		</script>

		<script type="text/javascript">
			function showDiv(elem) {
				if (elem.value == 0) {
					document.getElementById('photo_div').style.display = "none";
					document.getElementById('icon_div').style.display = "none";
				}
				if (elem.value == 1) {
					document.getElementById('photo_div').style.display = "block";
					document.getElementById('photo_div_existing').style.display = "block";
					document.getElementById('icon_div').style.display = "none";
				}
				if (elem.value == 2) {
					document.getElementById('photo_div').style.display = "none";
					document.getElementById('photo_div_existing').style.display = "none";
					document.getElementById('icon_div').style.display = "block";
				}
			}

			function showContentInputArea(elem) {
				if (elem.value == 'Full Width Page Layout') {
					document.getElementById('showPageContent').style.display = "block";
				} else {
					document.getElementById('showPageContent').style.display = "none";
				}
			}
		</script>

		<script type="text/javascript">
			// tesing
			$(document).ready(function() {
				// Add new FAQ fields dynamically
				$("#addNewFaq").click(function() {
					const newFaq = `
			<div class="faq-item">
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">Question <span>*</span></label>
					<div class="col-sm-9">
						<input type="text" autocomplete="off" class="form-control" name="faq_title[]" placeholder="Enter Title">
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label">Answer <span>*</span></label>
					<div class="col-sm-9">
						<textarea class="form-control" name="faq_content[]" placeholder="Enter Content" style="height:200px;"></textarea>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-9">
						<button type="button" class="btn btn-danger btn-xs deleteFaq">Delete</button>
					</div>
				</div>
			</div>`;
					$("#faqContainer").append(newFaq);
				});

				// Delete FAQ fields dynamically
				$("#faqContainer").on("click", ".deleteFaq", function() {
					$(this).closest(".faq-item").fadeOut("slow", function() {
						$(this).remove();
					});
				});
			});





			var items = [];
			for (i = 1; i <= 24; i++) {
				items[i] = document.getElementById("tabField" + i);
			}

			items[1].style.display = 'block';
			items[2].style.display = 'block';
			items[3].style.display = 'block';
			items[4].style.display = 'none';

			items[5].style.display = 'block';
			items[6].style.display = 'block';
			items[7].style.display = 'block';
			items[8].style.display = 'none';

			items[9].style.display = 'block';
			items[10].style.display = 'block';
			items[11].style.display = 'block';
			items[12].style.display = 'none';

			items[13].style.display = 'block';
			items[14].style.display = 'block';
			items[15].style.display = 'block';
			items[16].style.display = 'none';

			items[17].style.display = 'block';
			items[18].style.display = 'block';
			items[19].style.display = 'block';
			items[20].style.display = 'none';

			items[21].style.display = 'block';
			items[22].style.display = 'block';
			items[23].style.display = 'block';
			items[24].style.display = 'none';

			function funcTab1(elem) {
				var txt = elem.value;
				if (txt == 'Image Advertisement') {
					items[1].style.display = 'block';
					items[2].style.display = 'block';
					items[3].style.display = 'block';
					items[4].style.display = 'none';
				}
				if (txt == 'Adsense Code') {
					items[1].style.display = 'none';
					items[2].style.display = 'none';
					items[3].style.display = 'none';
					items[4].style.display = 'block';
				}
			};

			function funcTab2(elem) {
				var txt = elem.value;
				if (txt == 'Image Advertisement') {
					items[5].style.display = 'block';
					items[6].style.display = 'block';
					items[7].style.display = 'block';
					items[8].style.display = 'none';
				}
				if (txt == 'Adsense Code') {
					items[5].style.display = 'none';
					items[6].style.display = 'none';
					items[7].style.display = 'none';
					items[8].style.display = 'block';
				}
			};

			function funcTab3(elem) {
				var txt = elem.value;
				if (txt == 'Image Advertisement') {
					items[9].style.display = 'block';
					items[10].style.display = 'block';
					items[11].style.display = 'block';
					items[12].style.display = 'none';
				}
				if (txt == 'Adsense Code') {
					items[9].style.display = 'none';
					items[10].style.display = 'none';
					items[11].style.display = 'none';
					items[12].style.display = 'block';
				}
			};

			function funcTab4(elem) {
				var txt = elem.value;
				if (txt == 'Image Advertisement') {
					items[13].style.display = 'block';
					items[14].style.display = 'block';
					items[15].style.display = 'block';
					items[16].style.display = 'none';
				}
				if (txt == 'Adsense Code') {
					items[13].style.display = 'none';
					items[14].style.display = 'none';
					items[15].style.display = 'none';
					items[16].style.display = 'block';
				}
			};

			function funcTab5(elem) {
				var txt = elem.value;
				if (txt == 'Image Advertisement') {
					items[17].style.display = 'block';
					items[18].style.display = 'block';
					items[19].style.display = 'block';
					items[20].style.display = 'none';
				}
				if (txt == 'Adsense Code') {
					items[17].style.display = 'none';
					items[18].style.display = 'none';
					items[19].style.display = 'none';
					items[20].style.display = 'block';
				}
			};

			function funcTab6(elem) {
				var txt = elem.value;
				if (txt == 'Image Advertisement') {
					items[21].style.display = 'block';
					items[22].style.display = 'block';
					items[23].style.display = 'block';
					items[24].style.display = 'none';
				}
				if (txt == 'Adsense Code') {
					items[21].style.display = 'none';
					items[22].style.display = 'none';
					items[23].style.display = 'none';
					items[24].style.display = 'block';
				}
			};
		</script>

		</body>

		</html>