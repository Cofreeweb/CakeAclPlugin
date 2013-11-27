<?php echo $this->Html->image('/acl/img/icons/allow-' . $status . '.png',
                            array('onclick' => 'published.toggle("status-'.$user_id.'", "'.$this->Html->url('/acl/users/toggle/').$user_id.'/'.$status.'");',
                                  'id' => 'status-'.$user_id
        ));
?>