<footer class="footer">
        <div class="container">
         <!--  <nav>
            <ul>
              <li>
                <a href="https://www.creative-tim.com">
                  Creative Tim
                </a>
              </li>
              <li>
                <a href="http://presentation.creative-tim.com">
                  About Us
                </a>
              </li>
              <li>
                <a href="http://blog.creative-tim.com">
                  Blog
                </a>
              </li>
            </ul>
          </nav> -->
          <div class="copyright" id="copyright" style="color:grey;" align="center">
            &copy;
            <script>
              document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
            </script>, Designed and Developed by
            <a href="#" target="_blank"> <b>ETTM</b></a>.
          </div>
        </div>
      </footer>
    </div>
  </div>

<!--===============================================================================================-->
<script src="<?php echo base_url()?>assets/multiple_steps_form/multiple_steps.js"></script>
<!--===============================================================================================-->
<!--===============================================================================================-->
<script src="<?php echo base_url()?>assets/rc_assets/responsive_assets/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url()?>assets/rc_assets/responsive_assets/vendor/bootstrap/js/popper.js"></script>
	<script src="<?php echo base_url()?>assets/rc_assets/responsive_assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="<?php echo base_url()?>assets/rc_assets/responsive_assets/vendor/select2/select2.min.js"></script>
	<script>
		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});
	</script>
<!--===============================================================================================-->
	<script src="<?php echo base_url()?>assets/rc_assets/responsive_assets/js/main.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
  

</body>

</html>
