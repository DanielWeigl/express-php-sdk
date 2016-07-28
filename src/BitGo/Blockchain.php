<?php

namespace BitGo;

/**
 * Class Blockchain
 * Access decorator for blockchain inspection
 * @package BitGo
 */
class Blockchain {

	private $_bitgo;

	/**
	 * Blockchain constructor.
	 * @param BitGoSDK $bitgo
	 */
	public function __construct(BitGoSDK $bitgo) {
		$this->_bitgo = $bitgo;
	}

	/**
	 * Get address details
	 * @param $address string
	 * @return array
	 */
	public function getAddress($address) {
		return $this->_bitgo->get('address/' . $address);
	}

	/**
	 * Get address transactions
	 * @param $address string
	 * @return array
	 */
	public function getAddressTransactions($address) {
		return $this->_bitgo->get('address/' . $address . '/tx');
	}

	/**
	 * List the unspent outputs for a given address
	 * @param $address string
	 * @param null|int $limit least amount in satoshis for the unspents to match
	 * @return array
	 */
	public function getAddressUnspents($address, $limit = null) {
		$url = 'address/' . $address . '/unspents';
		if (is_numeric($limit)) {
			$url .= '?limit=' . urlencode($limit);
		}
		return $this->_bitgo->get($url);
	}

	/**
	 * Get transaction
	 * @param $txHash string
	 * @return array
	 */
	public function getTransaction($txHash) {
		return $this->_bitgo->get('tx/' . $txHash);
	}

	/**
	 * Get block
	 * @param $blockHash string
	 * @return array
	 */
	public function getBlock($blockHash) {
		return $this->_bitgo->get('block/' . $blockHash);
	}

}