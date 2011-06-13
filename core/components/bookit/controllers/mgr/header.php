<?php
$modx->regClientStartupScript($bookit->config['jsUrl'].'mgr/bookit.js');
$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    Bookit.config = '.$modx->toJSON($bookit->config).';
});
</script>');
return '';