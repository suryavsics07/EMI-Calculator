<?php
/* Template Name: Calculator Rent Buy */

error_reporting('E_ALL');
?>
<?php //get_header(); ?>
<style>
    div.calculator {
        font-size: 15px;
        color: #666;
        line-height: 24px;
        font-family:"Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;
        padding:0 15%;
    }
    div.calculator table {
        background-color: transparent;
        min-width:500px;
    }
    .calcTable {
        border-collapse: collapse;
        border: 1px solid;
        border-color: #BFBFBF;
    }
    .calcTable TH {
        color: #4685C4;
        background-color: #EDF3F8;
        border: 1px solid #4685C4;
        text-align: left;
        font-size: 140%;
        font-weight: bold;
        padding: 5px;
    }
    .calcTable TD.description {
        font-size: 100%;
        font-weight: bold;
        padding: 5px;
        text-align: justify;
        padding-left: 5px !important;
    }
    .calcTable tr>td:last-child {
        width: 60%;
    }
    .calcTable TR.oddRow {
        background-color: #EEE;
    }
    .calcTable  tr>td:first-child:not(.buttonBar) {
        padding-left: 50px;
    }
    .calcTable TD {
        border: 1px solid #bfbfbf;
        padding: 5px;
        color: #686868;
        line-height:24px;
    }
    .calcTable TD label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: 700;
    }
    .calcTable select {
        padding: 5px 20px;
        border: 1px solid #88B1D9;
        background: #f5f5f5;
        width: 100%;
        font-size: 11px;
        color: #777;
        cursor: pointer;
    }
    .calcTable tr td input {
        padding-left: 20px;
        border: 1px solid #88B1D9;
        margin: 0 10px 0 0;
        border-radius: 5px;
        width: 90%;
    }
    .calcTable tr td input[type=text] {
       
       width: 85%;
   }
    .calcTable TD.buttonBar {
        border-top: 1px solid #4685C4;
        background-color: #EDF3F8;
        text-align: center;
        padding: 15px 5px;
    }
    .calcTable .button, .calcTable td input.button {
        background-color: #fff;
        border: 1px solid #3773ac;
        color: #3773ac;
        font-size: 120%;
        font-weight: bold;
        padding: 2px 10px;
        cursor: pointer;
        border-radius: 0;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .calcTable  input.button+.button {
        border-color: #bbb;
        color: #777;
    }
    .calcTable  .alert {
        font-weight: bold;
        color: red;
        background: 0 0;
        padding: 12px 16px;
        margin-bottom: 24px;
    }
    .calcTable input.result {
        background-color: #e1edfd;
    }
    .calcTable input{
        height: 50px;
    }
    .calcTable input:checkbox{
        width: auto;
        float: left;
    }
</style>

<div class="calculator" style="position:relative">
<?php if(isset($_POST['submitFrm']) && (empty($_POST['cRent']) || empty($_POST['pPrice']) || empty($_POST['downPay'] ) || empty($_POST['loanLength']) || empty($_POST['iRate']  )  || empty($_POST['stayLength']     ) )) { ?>
    <font color="red">You must enter a <b>Current rent</b>, <b>Price of Home</b>, <b>down payment</b>, <b>Loan Term, <b>Intrest rate</b></b> <i>and</i> <b>Plan to stay home</b></font>
<?php } ?>
    <form name="calcForm" method="post" action="">
        <table cellspacing="0" class="calcTable" width="100%">
            <tbody><tr>
                <th colspan="3">Should I Rent or Buy?</th>
            </tr>

            <tr>
                <td colspan="3" class="description">
                    Use the calculator below to compare the advantages and disadvantages of owning vs. renting a home.
                </td>
            </tr>

            <tr class="oddRow">
                <td colspan="2" width="60%"><label for="cRent">Current Rent:</label></td>
                <td><input type="text" size="15" name="cRent" id="cRent" value="<?php echo $_POST['cRent']; ?>" required>
                </td>
            </tr>

            <tr class="evenRow">
                <td colspan="2"><label for="pPrice">Purchase Price of Home:</label></td>
                <td><input type="text" size="15" name="pPrice" id="pPrice" value="<?php echo $_POST['pPrice']; ?>" required>
                </td>
            </tr>

            <tr class="oddRow">
                <td colspan="2"><label for="downPay">Percentage of Down Payment(%):</label></td>
                <td><input type="text" size="15" name="downPay" id="downPay" value="<?php echo $_POST['downPay']; ?>" required maxlength="2">
                </td>
            </tr>

            <tr class="evenRow">
                <td colspan="2"><label for="loanLength">Length of Loan Term (years):</label></td>
                <td><input type="text" size="15" name="loanLength" id="loanLength" value="<?php echo $_POST['loanLength']; ?>" required></td>
            </tr>

            <tr class="oddRow">
                <td colspan="2"><label for="iRate">Interest Rate:</label></td>
                <td><input type="text" size="15" name="iRate" id="iRate" value="<?php echo $_POST['iRate']; ?>" required /> 
                </td>
            </tr>

            <tr class="evenRow">
                <td colspan="2"><label for="stayLength">Years You Plan to Stay in This Home:</label></td>
                <td><input type="text" size="15" name="stayLength" id="stayLength" value="<?php echo $_POST['stayLength']; ?>" required></td>
            </tr>

            <tr class="oddRow">
                <td colspan="2"><label for="PropTax">Yearly Property Tax Rate:(%)</label></td>
                <td><input type="text" size="15" name="PropTax" id="PropTax" value="<?php echo $_POST['PropTax'] ? $_POST['PropTax'] : 1; ?>">
                </td>
            </tr>

            <tr class="evenRow">
                <td colspan="2"><label for="homeAppreciate">Yearly Home Value Increase Rate:(%)</label></td>
                <td><input type="text" size="15" name="homeAppreciate" id="homeAppreciate" value="<?php echo $_POST['homeAppreciate']? $_POST['homeAppreciate'] : 2 ; ?>"></td>
            </tr>


            <tr>
                <td colspan="3" class="buttonBar">
                    <input type="submit" value="Compute" class="button"  name="submitFrm">
                    <input type="button" value="Reset" class="button" onclick="location.href=''">
                    <input type="hidden" name="submitCalc" value="1">
                    <input type="hidden" name="c" value="rentbuy">
                </td>
            </tr>

            <?php if(isset($_POST) && !empty($_POST['cRent']) && !empty($_POST['pPrice']) && !empty($_POST['downPay']) && !empty($_POST['loanLength']) && !empty($_POST['iRate']) && !empty($_POST['stayLength']) && !empty($_POST['PropTax']) && !empty($_POST['homeAppreciate']) ) { ?>
            <?php
                $monthlyRent = $_POST['cRent']; // monthly rent
                $homePrice = $_POST['pPrice']; // cost of home
                $downPay = $_POST['downPay'];
                $loanLength = $_POST['loanLength']; // loan terms
                $intRate = $_POST['iRate']/12/100; // loan anual intrest Rate
                $stayLength = $_POST['stayLength']; // Years you will stay at this property:
                $PropertyTax = $_POST['PropTax']; // yearly %
                $homeAppreciate = $_POST['homeAppreciate']; //Expected annual inflation rate (%):

                function paymentOfRent($yearOwn = 0,$rent = 0 , $homeAppreciate = 0){
                    $yearOwn =  $_POST['stayLength'];
                    $rent = $_POST['cRent'];
                    $homeAppreciate = $_POST['homeAppreciate']; 
                    $PropertyTax = $_POST['PropTax']; 
                   
                    $rentNew = pow(1.0228,($yearOwn - 1));  
                    $newRent = ($rentNew) + ($rentNew * $rent);

                    $monthlyRent = ((($newRent - $rent)/2) + ($rent));	
                    
                    $avgRent = ((($newRent - $monthlyRent)/2) + ($monthlyRent));	
                    
                    $totalRent =   $monthlyRent * $yearOwn * 12;	// total rent

                    return array(
                        'totalRent' => $totalRent,
                        'monthlyRent' => $monthlyRent,
                        'avgRent' => $avgRent

                    );

                }

                $Rent =  paymentOfRent();
    
               

                function paymentOfBuy($downPayPercent = 0,$homePrice = 0,$intRate,$newPropTax,$homeAppreciate, $yearLoan){
                    $loanAmount = $homePrice*(100-$downPayPercent)/100;
                    $IncInPricePercent = $homeAppreciate;
                    $interestRate = $_POST['iRate']/100;
                    $months = $yearLoan*12;

                    // aRate = 1 + (interestRate/12);

                 //EMI
                //  $payment = (int)($loanAmount * ($intRate-1) * pow($intRate,yearLoan*12)) / (pow($intRate,$yearLoan*12)-1);
                 $payment = $loanAmount * $intRate * (pow(1 + $intRate, $months) / (pow(1 + $intRate, $months) - 1)); // EMI

                // find home value after year of owning 
                    $yearOwn = $_POST['stayLength'];
                    $homeValAfterOwnYears = 0;
                    $incAmount = 0;
                    $homeValAfterOwnYears = $homePrice;
                    $pp = 1+ ($homeAppreciate/100);
                    $homeValAfterOwnYears = $homePrice * pow($pp,$yearOwn) ; // compound intrest


                    $monthlyInterest = $interestRate/12;

                    $loanMonths = $yearLoan * 12;
                    $ownPayMonths = $yearOwn * 12;

                    $PayOff = $loanAmount;
                    $interestDue = 0;
                    $pricipalCredit=0;

                    // Balance amount
                    if ((int)($yearOwn) < (int)($yearLoan)){		
                        for ($i=0;$i < $ownPayMonths; $i++) {
                            echo '<br/>'.$i;
                                $interestDue = $PayOff * $monthlyInterest;
                                $pricipalCredit = $payment - $interestDue;
                                $PayOff = $PayOff - $pricipalCredit;
                            }
                    
                            
                    }
                    else{
                        $PayOff = 0;
                    }
                   


                            // find the total interest 
                            $totalInterest=0;
                            $principalCredit = 0;
                            $intDue=0;
                            $remLoanAmount = $loanAmount;
                            // echo 'loanMonths'.$loanMonths;
                            // echo 'ownPayMonths'.$ownPayMonths;
                            if ((int)($yearOwn) <= (int)($yearLoan)){
                                for ($i=0; $i < $ownPayMonths; $i++) {	
                                    echo '<br/>ownPayMonths'.$i;
                                   $intDue = $loanAmount * $monthlyInterest;
                                    $principalCredit = $payment - $intDue;
                                    $remLoanAmount = $remLoanAmount - $principalCredit;
                                    $totalInterest = $totalInterest + $intDue;		
                                }
                            }
                            else {
                                for ($i=0; $i < $loanMonths; $i++) {	
                                    // echo '<br/>loanMonths'.$i;
                                    $intDue = $loanAmount * $monthlyInterest;
                                    $principalCredit = $payment - $intDue;
                                    $remLoanAmount = $remLoanAmount - $principalCredit;
                                    $totalInterest = $totalInterest + $intDue;		
                                }
                            }
                            
                            $totalInterest = ($totalInterest);

                            // find equity

                             $equity = 0;
                            $equity = $homeValAfterOwnYears - $PayOff;
                            

                        // find total property tax 

                            $loanTimePropertyTax = $newPropTax*$homePrice * $yearLoan/100;
                            $TPropertyTax = $newPropTax*$homePrice * $yearOwn/100;

                            // find total tax saving. assume personal tax rate is 28%.  

                            $TTSaving = 0;
                            if ((int)($yearOwn)<= (int)($yearLoan)) {

                                $TTSaving = (($totalInterest + $TPropertyTax)* 28 / 100);
                                }
                            else { 
                                $TTSaving = (($totalInterest + $loanTimePropertyTax)*28/100);
                                }
// echo $TTSaving;
                                // Total mortgage payment. Assume mortgage insurence rate 0.52%. 
                                // Assume loan closing cost rate 0.5%,  
                                // Home owning insurence .15%. 

                                $mortgagePayment = $payment * 12;

                                $mortgageIns = (0.52/100)*$loanAmount;
                                $loanClosingCost = $loanAmount * (0.5/100);
                               $homeOwnInsurence = $homePrice * (0.15/100);

                                $totalMortgagePayment = (($mortgagePayment + $mortgageIns));


                                if ((int)($yearOwn) <= (int)($yearLoan)){	
                                    $totalMortgagePayment = $totalMortgagePayment * $yearOwn + $homeOwnInsurence* $yearOwn + $TPropertyTax+ $loanClosingCost;
                                    }
                                else {
                                    $totalMortgagePayment = $totalMortgagePayment * $yearLoan + $homeOwnInsurence* $yearOwn + $TPropertyTax+ $loanClosingCost;		
                                    
                                    }


                                    // total cost of buying a home. Assume selling home cost 6%, 

                                    $costOfSellingHome = $homeValAfterOwnYears*6/100;

                                    $downPay = ($downPayPercent)/100 * $homePrice;
                                    $totalCost = 0;


                                   
                                    $totalCost = (($downPay+ $totalMortgagePayment+ $PayOff+ $costOfSellingHome)-($TTSaving+ $homeValAfterOwnYears));
                                    if ($totalCost < 0) $totalCost = 0;

                                    // monthly cost

                                    $monthlyCost = 0;
                                    $monthlyCost = ($totalCost/$yearOwn/12);
                                   
                                    $totalSaving = 0;
                                    $string = '';
                                    $Rent =  paymentOfRent();
                                    if ($Rent['totalRent'] > $totalCost){
                                        $totalSaving	= ($Rent['totalRent']) - ($totalCost);	
                                            $string = "Buying: ";
                                        }
                                    else{
                                        $totalSaving	= ($totalCost) - ($Rent['totalRent']);	
                                            $string = "Renting: ";
                                        }

                                    $string = $string . '$'.number_format( $totalSaving , 2);

                                    return array(
                                        'homeValAfterOwnYears' => $homeValAfterOwnYears,
                                        'remainingBalance' => $PayOff,
                                        'monthlyCost' => $monthlyCost,
                                        'totalCost' => $totalCost,
                                        'totalSaving' => $string,
                                        'TaxSaving' => $TTSaving,
                                        'equity' => $equity,
                                        'stayLength' => $stayLength


                                    );


                }

                $buyArray = paymentOfBuy($downPay,$homePrice , $intRate, $PropertyTax, $homeAppreciate, $loanLength);
                
            ?>
                <tr class="subHeading">
                    <td><strong>Result Returned:</strong></td>
                    <td><strong>Rent</strong></td>
                    <td><strong>Buy</strong></td>
                </tr>

                    <tr class="oddRow">
                        <td><label for="r18_rbcl">Price of Home After Appreciation:</label></td>
                        <td>&nbsp;</td>
                        <td><input class="result" size="15" id="r18_rbcl" name="r18" disabled="disabled" value="$<?php echo number_format($buyArray['homeValAfterOwnYears'],2); ?>"></td>
                    </tr>

                    <tr class="evenRow">
                        <td><label for="r17_rbcl">Remaining Balance After <?php echo $stayLength; ?> year(s):</label></td>
                        <td>&nbsp;</td>
                        <td><input class="result" size="15" id="r17_rbcl" name="r17" disabled="disabled" value="$<?php echo number_format($buyArray['remainingBalance'],2) ; ?>"></td>
                    </tr>

                    <tr class="oddRow">
                        <td><label for="r25_rbcl">Equity Earned:</label></td>
                        <td>&nbsp;</td>
                        <td style="display:none;"><input class="result" size="15" id="r25_rbcl" name="r25" disabled="disabled" value="$<?php echo number_format($homePriceAfterAppreciate - $buyArray['remainingBalance'],2); ?>"></td>
                        <td><input class="result" size="15" id="r25_rbcl" name="r25" disabled="disabled" value="$<?php echo number_format($buyArray['equity'],2); ?>"></td>
                        
                    </tr>

                    <tr class="evenRow">
                        <td><label for="r24_rbcl">Tax Savings (at 28%):</label></td>
                        <td>&nbsp;</td>
                        <td><input class="result" size="15" id="r24_rbcl" name="r24" disabled="disabled" value="$<?php echo number_format($buyArray['TaxSaving'], 2); ?>"></td>
                    </tr>

                    <tr class="oddRow">
                        <td><label for="r20_rbcl">Avg. Monthly Payment Over Time:</label><label style="display:none;" for="r19_rbcl">Rent Avg. Monthly Payment Over Time:</label></td>
                        <td><input class="result" size="15" id="r19_rbcl" name="r19" disabled="disabled" value="$<?php echo number_format($Rent['monthlyRent'],2); ?>"></td>
                        <td><input class="result" size="15" id="r20_rbcl" name="r20" disabled="disabled" value="$<?php echo number_format($buyArray['monthlyCost'],2); ?>"></td>
                    </tr>

                    <tr class="evenRow">
                        <td><label for="r22_rbcl">Total Payment:</label><label style="display:none;" for="r21_rbcl">Total Rent Payment:</label></td>
                        <td><input class="result" size="15" id="r21_rbcl" name="r21" disabled="disabled" value="$<?php echo number_format($Rent['totalRent'],2); ?>"></td>
                        <td><input class="result" size="15" id="r22_rbcl" name="r22" disabled="disabled" value="$<?php echo number_format($buyArray['totalCost'], 2); ?>"></td>
                    </tr>

                    <tr class="oddRow">
                        <td><label for="r23_rbcl">Total Savings On:</label></td>
                        <td colspan="2"><input class="result" size="35" id="r23_rbcl" name="r23" disabled="disabled" value="<?php echo $buyArray['totalSaving']; ?>"></td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <span class="description">
                            Note: The calculator above uses these items in its calculations: private mortgage insurance, homeowner's insurance cost, loan closing cost, cost of selling a home, property tax, homeowner's tax saving, and rent increases. Calculator results are estimates only.</span>
                        </td>
                    </tr>

            <?php } ?>
            
        </tbody></table>
</form>

</div>
<?php //get_footer(); ?>