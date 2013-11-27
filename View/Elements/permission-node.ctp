<?php
    $info = $this->viewVars['acos_details'][$data['Aco']['id']];
    $return = "<span title=\"{$info['description']}\">";

    if (!$hasChildren && $depth >= 2) {
        $return .= "<a href=\"javascript:;;\" onclick=\"acos.edit('{$this->Html->url('/acl/user_permissions/edit')}','{$data['Aco']['id']}'); return false;\">{$info['name']}</a>";
        //$return .= "&nbsp;&nbsp;".$this->Html->image('/acl/img/icons/user.png', array('style'=>'display:none'));
    }else{
      $return .= "<a href=\"javascript:;;\" onclick=\"acos.edit('{$this->Html->url('/acl/user_permissions/edit')}','{$data['Aco']['id']}'); return false;\">{$info['name']}</a>";
    }
    $return .= "</span>";

    echo $return;
?>
