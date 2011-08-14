<div class="view">
	<h3><?php echo sprintf(__('Acl Manager %s'), Configure::read('AclManager.version')); ?></h3>
	<p>This plugin allows you to easily manage your permissions. To use it you need to set up your Acl environment.</p>
	<p>Note: This plugin has only been designed to work with Actions as authorizer ($this->Auth->autorize = 'Actions').</p>
	<p>&nbsp;</p>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Manage permissions'), array('action' => 'permissions')); ?></li>
		<li><?php echo $this->Html->link(__('Update ACOs'), array('action' => 'update_acos')); ?></li>
		<li><?php echo $this->Html->link(__('Update AROs'), array('action' => 'update_aros')); ?></li>
		<li><?php echo $this->Html->link(__('Drop ACOs/AROs'), array('action' => 'drop'), array(), __("Do you want to drop all ACOs and AROs?")); ?></li>
		<li><?php echo $this->Html->link(__('Drop permissions'), array('action' => 'drop_perms'), array(), __("Do you want to drop all the permissions?")); ?></li>
	</ul>
</div>
