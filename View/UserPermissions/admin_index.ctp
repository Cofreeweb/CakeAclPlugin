<?php $this->Html->css( array( '/acl/css/treeview'), null, array( 'block' => 'css')) ?>
<?php $this->Html->script( array(
    '/acl/js/jquery.cookie',
    '/acl/js/treeview',
    '/acl/js/acos',
    '/acl/js/twitter/bootstrap-buttons',
), array( 'block' => 'script'))

?>
<div class="col-md-4">
    <div class="">
        <button class="btn btn-danger" data-loading-text="loading..." >Generate</button>
    </div>
    <div id="acos">
        <?php echo $this->Tree->generate($results, array('alias' => 'alias', 'plugin' => 'acl', 'model' => 'Aco', 'id' => 'acos-ul', 'element' => '/permission-node')); ?>
    </div>
</div>
<div class="col-md-4">
    <div id="aco-edit"></div>
</div>
<? $this->append('script') ?>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#acos").treeview({collapsed: true});
    });
    $(function() {
        var btn = $('.btn').click(function () {
            btn.button('loading');
            $.get('<?php echo $this->Html->url('/acl/user_permissions/sync');?>', {},
                function(data){
                    btn.button('reset');
                    $("#acos").html(data);
                }
            );
        })
    });
    </script>
<? $this->end() ?>