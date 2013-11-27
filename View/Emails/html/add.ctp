<p><?= __d( 'admin', 'Hola %s', array(
    $user ['User']['name']
)) ?>,</p>

<p><?= __d( 'admin', '%s te ha añadido como administrador del website %s.', array(
    Configure::read( 'Management.webname'),
    Configure::read( 'Config.domain')
)) ?></p>

<p><?= __d( 'admin', "Para poder administrarlo accede a %s y utiliza los siguientes datos:", array(
    $this->Html->url( array(
        'plugin' => 'acl',
        'admin' => true,
        'controller' => 'users',
        'action' => 'login'
    ), true)
))?></p>

<p><?= __d( 'admin', 'Email: %s', array(
    $user ['User']['email']
)) ?></p>
<p><?= __d( 'admin', 'Contraseña: %s', array(
    $password
)) ?></p>

