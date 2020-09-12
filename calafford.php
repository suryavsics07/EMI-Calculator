<?php
/* Template Name: Calculator Afford */
?>
<?php //get_header(); ?>
<style>
    div#overDiv {
        width: 940px;
        margin-left: -470px;
    }
    div#overDiv>table {
        float: right;
    }
    .popmenubg {
        background-color: #2b5985;
        padding: 2px 5px;
        font-weight: bold;
        line-height: 1.5em;
    }
    #overDiv table, #overDiv table tr, #overDiv table td {
        margin: 0;
    }
    #overDiv table td {
        padding: 0 5px;
    }
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
        width: 100%;
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
</style>
<div class="calculator" style="position:relative">
    <?php if(isset($_POST['submitFrm']) && (empty($_POST['grossPay']) || empty($_POST['downPay']) || empty($_POST['intRate']) )) { ?>
        <font color="red">You must enter a <b>Gross Pay</b>, <b>Down payment</b> <i>and</i> <b>Intrest Rate</b></font>
    <?php } ?>
    <form name="calcForm" action="" method="POST">
        <table cellspacing="0" class="calcTable" width="100%">

        <tbody>
		<tr>
                    <th colspan="2">Mortgage Qualification Calculator V1.1</th>
                </tr>
            	<tr>
			<td colspan="2" class="description">
			    This calculator will help you to determine how much house you can afford and/or qualify for.
			</td>
            	</tr>

            <tr class="oddRow">
                <td><label for="grossPay">Gross annual income:</label></td>
                <td><input type="TEXT" name="grossPay" id="grossPay" style="background-color:#ffffff" size="15" value="<?php echo $_POST['grossPay'] ?>" onfocus="return help01(this);" onblur="return nd();"></td>
            </tr>


            <tr class="evenRow">
                <td><label for="moDebts">Monthly debt payments:</label></td>
                <td><input type="TEXT" name="moDebts" id="moDebts" style="background-color:#ffffff" size="15" value="<?php echo $_POST['moDebts'] ?>" onfocus="return help02(this);" onblur="return nd();"></td>
            </tr>


            <tr class="oddRow">
                <td><label for="downPay">Down payment:</label></td>
                <td>
                    <input type="TEXT" name="downPay" id="downPay" style="background-color:#ffffff" size="15" value="<?php echo $_POST['downPay'] ?>" onfocus="return help03(this);" onblur="return nd();">
                </td>
            </tr>

            <tr class="evenRow">
                <td><label for="intRate">Annual interest rate:</label></td>
                <td>
                    <input type="TEXT" name="intRate" id="intRate" style="background-color:#ffffff" size="15" value="<?php echo $_POST['intRate'] ?>" onfocus="return help04(this);" onblur="return nd();">
                </td>
            </tr>

            <tr class="oddRow">
                <td><label for="moPMIPercent">Monthly Private Mortgage Insurance (PMI %):</label></td>
                <td>
                    <input type="TEXT" name="moPMIPercent" id="moPMIPercent" style="background-color:#ffffff" value="<?php echo $_POST['moPMIPercent'] ? $_POST['moPMIPercent'] :.4; ?>" size="15" onfocus="return help05(this);" onblur="return nd();">
                </td>
            </tr>

            <tr class="evenRow">
                <td><label for="moInsurance">Monthly insurance:</label></td>
                <td>
                    <input type="TEXT" name="moInsurance" id="moInsurance" style="background-color:#ffffff" size="15" value="<?php echo $_POST['moInsurance'] ?>" onfocus="return help06(this);" onblur="return nd();">
                </td>
            </tr>

            <tr class="oddRow">
                <td><label for="moPropTax">Monthly property tax:</label></td>
                <td>
                    <input type="TEXT" name="moPropTax" id="moPropTax" style="background-color:#ffffff" size="15" value="<?php echo $_POST['moPropTax'] ?>" onfocus="return help07(this);" onblur="return nd();">
                </td>
            </tr>

            <tr class="evenRow">
                <td><label for="term">Length of the mortgage:</label></td>
                <td>
                    <div class="select-option"><span class="ti-angle-down"></span><select name="term" id="term" size="1">
                        <option value="15" <?php echo $_POST['term'] == 15 ? 'selected': ''; ?> >15 Years
                        </option>
                        <option value="20" <?php echo $_POST['term'] == 20 ? 'selected': ''; ?>>20 Years
                        </option>
                        <option value="30" <?php echo $_POST['term'] == 30 ? 'selected': ''; ?>>30 Years
                        </option>
                        <option value="40" <?php echo $_POST['term'] == 40 ? 'selected': ''; ?>>40 Years
                    </option></select></div>
                </td>
            </tr>


            <input type="hidden" name="pmtRatio" value="28">
            <input type="hidden" name="debtRatio" value="36">


        <!-- button bar -->
        <tr>
            <td colspan="2" class="buttonBar">
                <input  type="submit" class="button" value="Compute" name="submitFrm">
                <input type="button" value="Reset" class="button" onclick="location.href=''">
                <input type="hidden" name="submitCalc" value="1">
                <input type="hidden" name="c" value="affordability">

            </td>
        </tr>
            <?php if(isset($_POST) && !empty($_POST['grossPay']) && !empty($_POST['downPay']) && !empty($_POST['intRate'])) { ?>
            <?php
                $grossPay = (float)$_POST['grossPay'];
                $downPay = (float)$_POST['downPay'];
                $intRate = (float)$_POST['intRate']/12/100;
                $moDebts = $_POST['moDebts'] > 0 ? (float)$_POST['moDebts']*50/100 : 0 ; // 36, 
                $moPMIPercent = (float)$_POST['moPMIPercent'];
                $moInsurance = (float)$_POST['moInsurance'];
                $moPropTax = (float)$_POST['moPropTax'];
                $term = (int)$_POST['term'];
                $months = $term*12;

                $remainingIncome = ((($grossPay/12)*28/100) ); // max salary you can spend on loan, it may be defer based on country or state
              

                // reference https://bootsnipp.com/snippets/ZV6Bx
                $p1 = 100000 ; // home loan
                $r1 = $intRate; // intrest rate
                $n1 = $term ; // years
                $incomeMonthly = (($remainingIncome)- $moDebts)-$moInsurance+$moPropTax; // monthly
                $perLacMonthlyEmi = ($p1 * $r1 * pow((1+$r1),$n1*12))/(pow((1+$r1),$n1*12)-1); // per Lac EMI monthly
                // $emi1 = ceil($perLacMonthlyEmi * 100) / 100; // to parse emi amount..
                $intrestTotal = (($perLacMonthlyEmi*$months )-$p1); // per Lac intrest
                $totalAmountPaid = ($perLacMonthlyEmi*$months ); 

                //Total Eligible Amount (fixedInc*0.5) - otherEmi)/perLacEmi)*100000)
                $loanEligibleAmount = (ceil($incomeMonthly) / $perLacMonthlyEmi)* $p1;
                $loanPrincipal = ($loanEligibleAmount - $loanEligibleAmount*$moPMIPercent/100);// minus PMI intrest
                $homePrice = $loanPrincipal + $downPay;
                
                /* monthlypaymrny formula ((yearlyintrestrate / 100 / 12) * loanPrincipal) / (1 - ((1 + (yearlyintrestrate / 100 / 12)) ^ (-loanTerm * 12))) */
               
                $monthlyPayment = $loanPrincipal * $intRate * (pow(1 + $intRate, $months) / (pow(1 + $intRate, $months) - 1));
                
               
            ?>
            <?php if($monthlyPayment <=0 ){ ?>
            <tr class="oddRow">
                <td colspan="2"><span class="alert">Based on industry standards you would not qualify for a home mortgage. In order to qualify you will need to either increase your annual income or lower your monthly debt payments, or a combination of both.</span></td>
            </tr>
            <?php } ?>
            <?php if($monthlyPayment > 0 ){ ?>
                <tr class="oddRow">
                    <td><label for="downPay2_acal"><a href="#return" name="downpayment" id="downpayment" onmouseover="return help10(this)" onmouseout="return nd();"><strong>?</strong></a> Downpayment:</label>
                    </td>
                    <td>
                        <input class="result" type="TEXT" id="downPay2_acal" name="downPay2" size="15" value="$<?php echo number_format($downPay,2); ?>" disabled="disabled">
                    </td>
                </tr>
                <tr class="evenRow">
                    <td><label for="loanAmt_acal"><a href="#return" name="lamount" id="lamount" onmouseover="return help11(this)" onmouseout="return nd();"><strong>?</strong></a> Loan Amount:</label>
                    </td>
                    <td>
                        <input class="result" type="TEXT" id="loanAmt_acal" name="loanAmt" size="15" value="$<?php echo number_format($loanPrincipal,2); ?>" disabled="disabled">
                    </td>
                </tr>
                <tr class="oddRow">
                    <td><label for="homePrice_acal"><a href="#return" name="hprice" id="hprice" onmouseover="return help12(this)" onmouseout="return nd();"><strong>?</strong></a> Home Price:</label>
                    </td>
                    <td>
                        <input class="result" type="TEXT" id="homePrice_acal" name="homePrice" size="15" value="$<?php echo number_format($homePrice,2); ?>" disabled="disabled">
                    </td>
                </tr>
                <tr class="evenRow">
                    <td><label for="_acal"><a href="#return" name="mpayment" id="mpayment" onmouseover="return help13(this)" onmouseout="return nd();"><strong>?</strong></a> Monthly Payment:</label>
                    </td>
                    <td>
                        <input class="result" type="TEXT" id="_acal" name="moPay" size="15" value="$<?php echo number_format($monthlyPayment,2  );?>" disabled="disabled">
                    </td>
                </tr>
                <?php } ?>
            <?php } ?>

        </tbody>
    </table>
    </form>
</div>
<script type="text/javascript" src="overlib_mini.js"></script>
<script type="text/javascript" src="overlib_anchor_mini.js"></script>
<script language="Javascript">
    

    function help01(element) {
        return overlib("ENTER: Your gross annual household income.  This is the amount before taxes are deducted.", CAPTION, "Gross Annual Income", ANCHOR, "grossPay", ANCHORALIGN, "UR", "LL");
    }

    function help02(element) {

        return overlib("ENTER: The total of your non-mortgage monthly debt payments. This would include car loans, student loans, credit card payments and so on.", CAPTION, "Monthly Debt Payments", ANCHOR, "moDebts", ANCHORALIGN, "UR", "LL");
    }

    function help03(element) {
        return overlib("ENTER: The amount you have available to cover the mortgage down payment and closing costs.", CAPTION, "Down Payment", ANCHOR, "downPay", ANCHORALIGN, "UR", "LL");
    }

    function help04(element) {
        return overlib("ENTER: The annual interest rate you expect to pay on this mortgage. You can enter the rate either as a percentage (8.25) or as a decimal (.0825), whichever you prefer.", CAPTION, "Annual Interest Rate", ANCHOR, "intRate", ANCHORALIGN, "UR", "LL");
    }

    function help05(element) {
        return overlib("ENTER: The monthly Private Mortgage Insurance (PMI) you expect to pay. If your downpayment is less than 20% of the value of the home you are buying, you may be required to pay mortgage insurance of somewhere between 0.2% and 0.5% of your principal balance each month. Enter .04% simply as .4 (do not include percent sign).", CAPTION, "PMI", ANCHOR, "moPMIPercent", ANCHORALIGN, "UR", "LL");
    }

    function help06(element) {
        return overlib("ENTER: The monthly insurance payment you expect to pay. As a rule of thumb, you can expect to pay .125% (home price X .00125) of the purchase price per month.", CAPTION, "Monthly Insurance", ANCHOR, "moInsurance", ANCHORALIGN, "UR", "LL");
    }

    function help07(element) {
        return overlib("ENTER: The monthly property tax payment you expect to pay. As a rule of thumb, you can expect to pay .027% (home price X .00027) of the purchase price per month.", CAPTION, "Monthly Property Tax", ANCHOR, "moPropTax", ANCHORALIGN, "UR", "LL");
    }

    function help08(element) {
        return overlib("ENTER: Your area's maximum mortgage payment to income ratio. The default ratio is 28%, in which case your mortgage payment cannot exceed 28% of your monthly income.", CAPTION, "Maximum mortgage payment to income ratio", ANCHOR, "grossPay", ANCHORALIGN, "UR", "LL");
    }

    function help09(element) {
        return overlib("ENTER: Your area's maximum mortgage payment plus debt payments to income ratio. The default ratio is 36%, in which case your mortgage payment plus your debt payments cannot exceed 36% of your monthly income.", CAPTION, "Maximum debt payments to income ratio", ANCHOR, "grossPay", ANCHORALIGN, "UR", "LL");
    }

    //GIVE RESULT EXPLANATIONS

    function help10(element) {
        return overlib("This is your original down payment amount.", CAPTION, "Downpayment", ANCHOR, "downpayment", ANCHORALIGN, "UR", "LL", ANCHORY, -7);
    }

    function help11(element) {
        return overlib("This is the maximum mortgage you would qualify for based on your current entries.", CAPTION, "Loan Amount", ANCHOR, "lamount", ANCHORALIGN, "UR", "LL", ANCHORY, -7);
    }

    function help12(element) {
        return overlib("This is home price you could afford (the total of your down payment and your maximum mortgage amount.", CAPTION, "Home Price", ANCHOR, "hprice", ANCHORALIGN, "UR", "LL", ANCHORY, -7);
    }

    function help13(element) {
        return overlib("This is your maximum monthly mortgage payment based upon your current entries.", CAPTION, "Monthly Payment", ANCHOR, "mpayment", ANCHORALIGN, "UR", "LL", ANCHORY, -7);
    }
</script>
<?php //get_footer(); ?>
<script>
    function calculateEmi(p="", r="", t=""){
	var res = [];
    var emi = interestValue = totalAmt = 0; 

    if(p < 1 || r < 0 || t < 1 ){
		res['emiValue'] = "";
		res['TotalValue'] = "";
    }
    else{
        var principal = parseFloat(p);
        var interest = parseFloat(r) / 100 / 12;
        var payments = parseFloat(t) * 12;

        var x = Math.pow(1 + interest, payments); //Math.pow computes powers
        var monthly = (principal*x*interest)/(x-1);

        if (isFinite(monthly)){
            emi = monthly.toFixed(2);
            interestValue = ((monthly*payments)-principal).toFixed(2);
            totalAmt = (monthly * payments).toFixed(2);
        }
        
		res['emiValue'] = emi;
		res['TotalValue'] = totalAmt;
		// res['interestValue'] = interestValue;
    }
	return res;
}

function checkEligiblity(p="", r="", t="", fixedInc="", existingEmi=""){
	var res = [];

	if(fixedInc < 1 || existingEmi < 0 || p < 1 || r < 0 || t < 1){
		res['loanElgAmount'] = 0;
	}else{
		//Per Lac EMI
		var perLacEmi = calculateEmi(p, r, t)['emiValue'],
		perLacEmi = Math.ceil(perLacEmi),
		fixedInc = Math.ceil(fixedInc),
		otherEmi = Math.ceil(existingEmi);
		
		//Total Eligible Amount
		res['loanElgAmount'] = Math.ceil((((fixedInc*0.5) - otherEmi)/perLacEmi)*100000);	
		if(res['loanElgAmount'] < 1 || !isFinite(res['loanElgAmount'])){
			res['loanElgAmount'] = 0;
		}else{
			//EMI for this Eligible Amout
			var elgMonthlyEmi = calculateEmi(res['loanElgAmount'], r, t)['emiValue'];
			res['elgMonthlyEmi'] = Math.ceil(elgMonthlyEmi);
		}
	}
	return res;
}

function numberWithCommas(x) {
	return x.toLocaleString('en-IN');
    // return x.toString().replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
}
console.log( checkEligiblity(p=100000, r=9, t=20, fixedInc=80000, existingEmi=15000));
    </script>
