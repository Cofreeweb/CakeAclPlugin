<?php echo $this->Tree->generate($results, array('alias' => 'alias', 'plugin' => 'acl', 'model' => 'Aco', 'id' => 'acos-ul', 'element' => '/permission-node')); ?>
<script type="text/javascript">
$(document).ready(function() {
    $("#acos").treeview({collapsed: true});
});
</script>