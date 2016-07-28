<?php

class BlockchainTest extends PHPUnit_Framework_TestCase {

	public function testGetAddress() {
		$bitgo = new \BitGo\BitGoSDK();
		$blockchain = $bitgo->blockchain();
		$addressDetails = $blockchain->getAddress('2MtepahRn4qTihhTvUuGTYUyUBkQZzaVBG3');
		$this->assertArrayHasKey('balance', $addressDetails);
		$this->assertArrayHasKey('confirmedBalance', $addressDetails);
		$this->assertArrayHasKey('unconfirmedSends', $addressDetails);
		$this->assertArrayHasKey('unconfirmedReceives', $addressDetails);
		$this->assertArrayHasKey('spendableBalance', $addressDetails);
		$this->assertArrayHasKey('sent', $addressDetails);
		$this->assertArrayHasKey('received', $addressDetails);
		$this->assertArrayHasKey('address', $addressDetails);
		$this->assertEquals('2MtepahRn4qTihhTvUuGTYUyUBkQZzaVBG3', $addressDetails['address']);
		$this->assertGreaterThanOrEqual(15078543665, $addressDetails['sent']);
		$this->assertGreaterThanOrEqual(15334243665, $addressDetails['received']);
	}

	public function testGetAddressTransactions() {
		$bitgo = new \BitGo\BitGoSDK();
		$blockchain = $bitgo->blockchain();
		$result = $blockchain->getAddressTransactions('2MtepahRn4qTihhTvUuGTYUyUBkQZzaVBG3');
		$this->assertArrayHasKey('start', $result);
		$this->assertArrayHasKey('count', $result);
		$this->assertArrayHasKey('total', $result);
		$this->assertArrayHasKey('transactions', $result);
		$this->assertGreaterThanOrEqual(10500, $result['total']);
		$transactions = $result['transactions'];
		$firstTransaction = $transactions[0];
		$this->assertNotEmpty($firstTransaction['id']);
		$this->assertNotEmpty($firstTransaction['normalizedHash']);
		$this->assertNotEmpty($firstTransaction['date']);
		$this->assertNotEmpty($firstTransaction['fee']);
		$this->assertNotEmpty($firstTransaction['blockhash']);
		$this->assertNotNull($firstTransaction['pending']);
		$this->assertArrayHasKey('inputs', $firstTransaction);
		$this->assertArrayHasKey('outputs', $firstTransaction);
		$this->assertArrayHasKey('entries', $firstTransaction);
	}

	public function testGetAddressUnspents() {
		$bitgo = new \BitGo\BitGoSDK();
		$blockchain = $bitgo->blockchain();
		$result = $blockchain->getAddressUnspents('2MtepahRn4qTihhTvUuGTYUyUBkQZzaVBG3');
		$this->assertArrayHasKey('pendingTransactions', $result);
		$this->assertArrayHasKey('count', $result);
		$this->assertArrayHasKey('total', $result);
		$this->assertArrayHasKey('start', $result);
		$this->assertArrayHasKey('unspents', $result);
		$this->assertGreaterThanOrEqual(194, $result['total']);
		$this->assertEquals($result['count'], count($result['unspents']));
		$firstUnspent = $result['unspents'][0];
		$this->assertNotEmpty($firstUnspent['date']);
		$this->assertNotEmpty($firstUnspent['tx_hash']);
		$this->assertNotEmpty($firstUnspent['value']);
		$this->assertNotEmpty($firstUnspent['address']);
	}

	public function testGetTransaction() {
		$bitgo = new \BitGo\BitGoSDK();
		$blockchain = $bitgo->blockchain();
		$transaction = $blockchain->getTransaction('c8ba43a21f1d94ad2dc98aced6271171642cda0ef527e0e0706542b0f2f6207f');
		$this->assertNotEmpty($transaction['id']);
		$this->assertNotEmpty($transaction['normalizedHash']);
		$this->assertNotEmpty($transaction['date']);
		$this->assertNotEmpty($transaction['fee']);
		$this->assertNotEmpty($transaction['inputs']);
		$this->assertNotEmpty($transaction['outputs']);
		$this->assertNotEmpty($transaction['entries']);
		$this->assertNotEmpty($transaction['confirmations']);
		$this->assertNotEmpty($transaction['blockhash']);
		$this->assertNotEmpty($transaction['height']);
		$this->assertNotEmpty($transaction['hex']);
		$this->assertEquals('c8ba43a21f1d94ad2dc98aced6271171642cda0ef527e0e0706542b0f2f6207f', $transaction['id']);
		$this->assertEquals('5d51c2f73fcdaf7188bbb997d31fdcda70ed1727a6b64c1afcb1e870c9e8c200', $transaction['normalizedHash']);
		$this->assertEquals(4107, $transaction['fee']);
		$this->assertEquals(false, $transaction['pending']);
		$this->assertEquals('0000000000030ca36cab12f4a731b9d72e88ea1484ab5f259b5fcca4df5fa2e7', $transaction['blockhash']);
		$this->assertCount(1, $transaction['inputs']);
		$this->assertCount(2, $transaction['outputs']);
		$this->assertCount(3, $transaction['entries']);
	}

	public function testGetBlock() {
		$bitgo = new \BitGo\BitGoSDK();
		$blockchain = $bitgo->blockchain();
		$block = $blockchain->getBlock('0000000000030ca36cab12f4a731b9d72e88ea1484ab5f259b5fcca4df5fa2e7');
		$this->assertEquals('0000000000030ca36cab12f4a731b9d72e88ea1484ab5f259b5fcca4df5fa2e7', $block['id']);
		$this->assertGreaterThanOrEqual(913419, $block['height']);
		$this->assertEquals('271661366471078034487', $block['chainWork']);
		$this->assertEquals('0000000000036b5c92db49a01a7b49fc2d24c88abc04fffb89348b37f9e63f18', $block['previous']);
		$this->assertCount(4, $block['transactions']);
	}

}
