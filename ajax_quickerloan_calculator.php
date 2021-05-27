<?php error_reporting(E_ALL);
if(!empty($_POST['purchasePrice']) && !empty($_POST['downPayment'])){
    $purchasePrice = (float)$_POST['purchasePrice'];
    $downPayment = (float)$_POST['downPayment'];
    $leadTypeCode = $_POST['leadTypeCode'];
    $zipCode = $_POST['zipCode'];
    $creditScore = $_POST['creditScore'];
    $purchRate = (float)$_POST['purchRate'];
    $purchApr = (float)$_POST['purchApr'];
    $productDescription = $_POST['purchProduct'];
    $purchProduct = explode('-',$productDescription);

    $loanAmount = $purchasePrice - $downPayment;
    if ($loanAmount < 25000 || $loanAmount > 3000000) {
        $result =  array('status'=>0, 'message'=>'Loan amount must be $25,000 - $3,000,000');
    }else{

        $homePrice = $_POST['sale_price'];
        $intRate = (float)$purchRate/12/100;
        $term = (int)$purchProduct[0];
        $months = $term*12;

        $monthlyPayment = $loanAmount * $intRate * (pow(1 + $intRate, $months) / (pow(1 + $intRate, $months) - 1));/* EMI */

        $pmi = (55/100000)*$loanAmount; //$55 per 100000



        $generalDisclaimers = array(
            "Name" => "Mortgage Rate",
            "Text" => "Mortgage rates could change daily. Remember - we do not have all your information, so the rate and payment results you see above may not completely reflect your actual situation. Quicken Loans offers a wide variety of loan options, and you might still qualify for a loan even if your situation doesn't match our assumptions.  Certain restrictions may apply."
        );
        $assumptions = "<p>Mortgage rates could change daily. Actual payments will vary based on your individual situation and current rates. Some products may not be available in all states. Some jumbo products may not be available to first time home buyers. Lending services may not be available in all areas. Some restrictions may apply. Based on the purchase\/refinance of a primary residence with no cash out at closing. We assumed (unless otherwise noted) that: closing costs are paid out of pocket; this is your primary residence and is a single family home; debt-to-income ratio is less than 30%; and credit score is over 720, or in the case of certain Jumbo products we assume a credit score over 740; and an escrow account for the payment of taxes and insurance. The lock period for your rate is 45 days. The loan to value (LTV) ratio is 66.67%. If LTV &gt; 80%, PMI will be added to your monthly mortgage payment, with the exception of Military\/VA loans. Military\/VA loans do not require PMI.<\/p>\n\n\t<p>Please remember that we don&#8217;t have all your information. Therefore, the rate and payment results you see from this calculator may not reflect your actual situation. Quicken Loans offers a wide variety of loan options. You may still qualify for a loan even if your situation doesn&#8217;t match our assumptions. To get more accurate and personalized results, please call (800) 251-9080 to talk to one of our mortgage experts.<\/p>";

        $filledDisclaimers = "<span class=\"legal__copy--title\">30-year Fixed-Rate Loan:<\/span> The payment on a $2,000,000.00 30-year Fixed-Rate Loan at ".$purchRate."% (".$purchApr."% APR) is $".$monthlyPayment." for the cost of 1.625 point(s) due at closing and a loan-to-value (LTV) of 66.667%. One point is equal to one percent of your loan amount. Payment does not include taxes and insurance. The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply.";
        $productDescription = "30-Year Fixed";
        $result = array('status'=>1,
                    'productDescription'=> $productDescription,
                    "rate"=>$purchRate,
                    "APR" =>$purchApr,
                    "term" =>$term,
                    "cashOutAmount"=>0,
                    "totalMonthlyPayment"=>number_format($monthlyPayment,2),
                    "monthlyPaymentBreakdown"=> array(
                        "mortgageInsurancePayment"=>0,
                        "principleAndInterestPayment"=>0,
                        "monthlyInsurancePayment"=>0,
                        "monthlyTaxPayment"=>0
                    ),
                    "closingPoints"=>0,
                    "closingCostBreakdown"=> array(
                        "totalNetFees"=>40500.5,
                        "vaFundingFee"=>0,
                        "ufmip"=>0
                    ),
                    "productCode" => "QJ30",
                    "filledDisclaimers" => $filledDisclaimers,
                    "armInfo" => null,
                    "assumptions" => $assumptions,
                    "generalDisclaimers" => $generalDisclaimers,
                    "transactionId" =>rand(range(333, 99999))

                );
    }
}else{
    $result =  array('status'=>0, 'message'=>'');;
}
echo json_encode($result);
//{"productDescription":"30-Year Jumbo Fixed","rate":2.875,"APR":3.024,"term":30,"cashOutAmount":0,"totalMonthlyPayment":8297.85,"monthlyPaymentBreakdown":{"mortgageInsurancePayment":0,"principleAndInterestPayment":8297.85,"monthlyInsurancePayment":325,"monthlyTaxPayment":3125},"closingPoints":1.625,"closingCostBreakdown":{"totalNetFees":40500.5,"vaFundingFee":0,"ufmip":0},"productCode":"QJ30","filledDisclaimers":["<span class=\"legal__copy--title\">30-year Fixed-Rate Loan:<\/span> The payment on a $2,000,000.00 30-year Fixed-Rate Loan at 2.875% (3.024% APR) is $8,297.85 for the cost of 1.625 point(s) due at closing and a loan-to-value (LTV) of 66.667%. One point is equal to one percent of your loan amount. Payment does not include taxes and insurance. The actual payment amount will be greater. Some state and county maximum loan amount restrictions may apply."],"armInfo":null,"assumptions":"<p>Mortgage rates could change daily. Actual payments will vary based on your individual situation and current rates. Some products may not be available in all states. Some jumbo products may not be available to first time home buyers. Lending services may not be available in all areas. Some restrictions may apply. Based on the purchase\/refinance of a primary residence with no cash out at closing. We assumed (unless otherwise noted) that: closing costs are paid out of pocket; this is your primary residence and is a single family home; debt-to-income ratio is less than 30%; and credit score is over 720, or in the case of certain Jumbo products we assume a credit score over 740; and an escrow account for the payment of taxes and insurance. The lock period for your rate is 45 days. The loan to value (LTV) ratio is 66.67%. If LTV &gt; 80%, PMI will be added to your monthly mortgage payment, with the exception of Military\/VA loans. Military\/VA loans do not require PMI.<\/p>\n\n\t<p>Please remember that we don&#8217;t have all your information. Therefore, the rate and payment results you see from this calculator may not reflect your actual situation. Quicken Loans offers a wide variety of loan options. You may still qualify for a loan even if your situation doesn&#8217;t match our assumptions. To get more accurate and personalized results, please call (800) 251-9080 to talk to one of our mortgage experts.<\/p>","generalDisclaimers":[{"Name":"Mortgage Rate","Text":"Mortgage rates could change daily. Remember - we do not have all your information, so the rate and payment results you see above may not completely reflect your actual situation. Quicken Loans offers a wide variety of loan options, and you might still qualify for a loan even if your situation doesn't match our assumptions.  Certain restrictions may apply."}],"transactionId":"5cab2ae1-21f7-4c0a-bf2d-c276a1adbd0f"} 