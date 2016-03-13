</div>
</div>

  <script src="<?=wings_assets_dir('wings/')?>/bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
  <script src="<?=wings_assets_dir('wings/')?>/bower_components/semantic/dist/semantic.min.js" type="text/javascript"></script>
  <script>
  (function($){
    $('.dropdown').dropdown({'on':'hover'});
    $('.message .close').on('click', function(){
        $(this)
      .closest('.message')
      .transition('fade')
      });

  })(jQuery);
    </script>
  </body>
  </html>
