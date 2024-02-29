<?php

require "../../mpgClasses.php";

$store_id='monca03650';
$api_token='7Yw0MPTlhjBRcZiE6837';

/************************* Transactional Variables ****************************/

$type='preauth';
$cust_id='cust id';
$order_id='ord-'.date("dmy-G:i:s");
$amount='6000.00';
$pan='4622943127023886';
$expdate='2212';
$crypt='7';
$dynamic_descriptor='123';
$status_check = 'false';

// TrId and TokenCryptogram are optional, refer documentation for more details.
$tr_id = '50189815682';
$token_cryptogram = 'APmbM/411e0uAAH+s6xMAAADFA==';

$txnArray=array('type'=>$type,
         'order_id'=>$order_id,
         'cust_id'=>$cust_id,
         'amount'=>$amount,
         'pan'=>$pan,
         'expdate'=>$expdate,
         'crypt_type'=>$crypt,
         'dynamic_descriptor'=>$dynamic_descriptor
		 //,'cm_id' => '8nAK8712sGaAkls56' //set only for usage with Offlinx - Unique max 50 alphanumeric characters transaction id generated by merchant
         //,'tr_id' => $tr_id
		 //,'token_cryptogram' => $token_cryptogram
        );


$mpgTxn = new mpgTransaction($txnArray);

/******************* Credential on File **********************************/

$cof = new CofInfo();
$cof->setPaymentIndicator("U");
$cof->setPaymentInformation("2");
$cof->setIssuerId("139X3130ASCXAS9");

$mpgTxn->setCofInfo($cof);

/******************* Installment Info *OPTIONAL* **********************************/

$installmentInfo = new InstallmentInfo();
$installmentInfo->setPlanId("ae859ef1-eb91-b708-8b80-1dd481746401");
$installmentInfo->setPlanIdRef("0000000065");
$installmentInfo->setTacVersion("2");

//$mpgTxn->setInstallmentInfo($installmentInfo);


$mpgRequest = new mpgRequest($mpgTxn);
$mpgRequest->setProcCountryCode("CA"); //"US" for sending transaction to US environment
$mpgRequest->setTestMode(true); //false or comment out this line for production transactions

$mpgHttpPost  =new mpgHttpsPost($store_id,$api_token,$mpgRequest);

$mpgResponse=$mpgHttpPost->getMpgResponse();

print("\nCardType = " . $mpgResponse->getCardType());
print("\nTransAmount = " . $mpgResponse->getTransAmount());
print("\nTxnNumber = " . $mpgResponse->getTxnNumber());
print("\nReceiptId = " . $mpgResponse->getReceiptId());
print("\nTransType = " . $mpgResponse->getTransType());
print("\nReferenceNum = " . $mpgResponse->getReferenceNum());
print("\nResponseCode = " . $mpgResponse->getResponseCode());
print("\nISO = " . $mpgResponse->getISO());
print("\nMessage = " . $mpgResponse->getMessage());
print("\nIsVisaDebit = " . $mpgResponse->getIsVisaDebit());
print("\nAuthCode = " . $mpgResponse->getAuthCode());
print("\nComplete = " . $mpgResponse->getComplete());
print("\nTransDate = " . $mpgResponse->getTransDate());
print("\nTransTime = " . $mpgResponse->getTransTime());
print("\nTicket = " . $mpgResponse->getTicket());
print("\nTimedOut = " . $mpgResponse->getTimedOut());
print("\nIssuerId = " . $mpgResponse->getIssuerId());
print("\nSourcePanLast4 = " . $mpgResponse->getSourcePanLast4());

// $installmentResults = $mpgResponse->getInstallmentResults();

// print("\nPlanId = " . $installmentResults->getPlanId());
// print("\nPlanIDRef = " . $installmentResults->getPlanIDRef());
// print("\nTacVersion = " . $installmentResults->getTacVersion());
// print("\nPlanAcceptanceId = " . $installmentResults->getPlanAcceptanceId());
// print("\nPlanStatus = " . $installmentResults->getPlanStatus()); 
// print("\nPlanResponse = " . $installmentResults->getPlanResponse());

?>

