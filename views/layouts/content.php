<?php
use liumapp\library\widgets\ui\Alert;
?>
<div class="content-wrapper">
    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="http://www.huluwa.cc">HLW</a>.</strong> All rights
    reserved.
</footer>