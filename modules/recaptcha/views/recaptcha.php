<script type="text/javascript">
  var RecaptchaOptions = {
    theme:"<?php print  $theme ?>"
  };
</script>
<script type="text/javascript" src="<?php print  $server ?>/challenge?k=<?php print  $key . $errorpart?>"></script>

<noscript>
        <iframe src="<?php print  $server ?>/noscript?k=<?php print  $key.$errorpart ?>" height="300" width="500" frameborder="0"></iframe><br/>
        <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
        <input type="hidden" name="recaptcha_response_field" value="manual_challenge"/>
</noscript> 