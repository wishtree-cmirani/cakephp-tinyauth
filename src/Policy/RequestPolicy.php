<?php

namespace TinyAuth\Policy;

use Authorization\IdentityInterface;
use Authorization\Policy\RequestPolicyInterface;
use Cake\Core\InstanceConfigTrait;
use Cake\Http\ServerRequest;
use TinyAuth\Auth\AclTrait;
use TinyAuth\Auth\AllowTrait;
use TinyAuth\Utility\Config;

/**
 * Used for middleware approach.
 */
class RequestPolicy implements RequestPolicyInterface {

	use AclTrait;
	use AllowTrait;
	use InstanceConfigTrait;

	/**
	 * @var array
	 */
	protected $_defaultConfig = [
	];

	/**
	 * @param array $config
	 */
	public function __construct(array $config = []) {
		$config += Config::all();

		$this->setConfig($config);
	}

	/**
	 * Method to check if the request can be accessed
	 *
	 * @param \Authorization\IdentityInterface|null $identity Identity
	 * @param \Cake\Http\ServerRequest $request Request
	 * @return bool
	 */
	public function canAccess(?IdentityInterface $identity, ServerRequest $request) {
		$params = $request->getAttribute('params');
		$user = $identity ? (array)$identity->getOriginalData() : [];

		return $this->_checkUser($user, $params);
	}

}
