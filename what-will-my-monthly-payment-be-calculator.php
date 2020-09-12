<?php
/* 
    Template Name: Calculator Mortgage Monthly Payment
*/
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
        width: 100%;
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
    .calcTable  td input[type=text] {
        width: 60%;
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
    
    .calcTable .total {
        background: #ccf3ff;
        color: #4988c5;
    }
    .calcTable .subtotal {
        background: #e5edf7;
    }
    calcTable .noted {
        background: #f5f8fc;
    }



    /* */
    .resTable {
        border-collapse: collapse;
        border: 1px solid;
        border-color: #BFBFBF;
    }
    .resTable td {
        border: 1px solid #bfbfbf;
        padding: 5px;
    }
    .resTable .noted {
        background: #dde6f5;
    }
    .resTable TH {
        color: #4685C4;
        background-color: #EDF3F8;
        border: 1px solid #4685C4;
        text-align: left;
        font-size: 140%;
        font-weight: bold;
        padding: 5px;
    }
    .resTable TD.description {
        font-size: 100%;
        font-weight: bold;
        padding: 5px;
    }
    .resTable tr>td:last-child {
        width: 60%;
    }
    .resTable TR.oddRow {
        background-color: #EEE;
    }
    .resTable  tr>td:first-child:not(.buttonBar) {
        padding-left: 50px;
    }
    .resTable TD {
        border: 1px solid #bfbfbf;
        padding: 5px;
        color: #686868;
        color: #666;
        font-size: 15px;
    }
    .resTable TD label {
        display: inline-block;
        max-width: 100%;
        margin-bottom: 5px;
        font-weight: 700;
    }

    .amortization {
        background: #eee;
        border-collapse: collapse;
        border: 1px solid;
        border-color: #BFBFBF;
        margin-top: 10px;
    }
    .amortization .noted {
        background: #dbe6f4;
    }
    .amortization .subhead {
        background: #d9e6f4;
    }
    .amortization .totals {
        background: #e2ebf6;
    }
    .amortization .blank {
        background: #fff;
    }
    .amortization .common {
        background: #eee;
    }
    .amortization td {
        border: 1px solid #bfbfbf;
        padding: 5px;
        color: #666;
        font-size: 15px;
        line-height: 24px!important;
    }
    .amortization td:first-child:not(.buttonBar) {
        padding-left: 50px;
    }
</style>
<div class="calculator " style="position:relative">
<?php if(isset($_POST['submitFrm']) && (empty($_POST['sale_price']) || empty($_POST['year_term']) || empty($_POST['annual_interest_percent']) )) { ?>
    <font color="red">You must enter a <b>Sale Price of Home</b>, <b>Length of Mortgage</b> <i>and</i> <b>Annual Interest Rate</b></font>
<?php } ?>
        <form name="calcForm" action="" method="POST">
            <input type="hidden" name="c" value="monthly">
            <input type="hidden" name="form_complete" value="1">
            <table class="calcTable" cellspacing="0" width="100%">


                <tbody><tr>
                    <th colspan="2">Mortgage Payment Calculator</th>
                </tr>

                <tr>
                    <td colspan="2" class="description">
                        This mortgage calculator can be used to figure out monthly payments of a home mortgage loan,
                        based on the home's sale price, the term of the loan desired, buyer's down payment percentage,
                        and the loan's interest rate. This calculator factors in PMI (Private Mortgage Insurance) for
                        loans where less than 20% is put as a down payment. Also taken into consideration are the town
                        property taxes, and their effect on the total monthly mortgage payment.
                    </td>
                </tr>
                <tr class="oddRow">
                    <td align="left"><label for="sale_price">Sale Price of Home:</label></td>
                    <td><input type="text" size="10" name="sale_price" id="sale_price" value="<?php echo $_POST['sale_price']; ?>"><span class="description">(In Dollars)</span>
                    </td>
                </tr>
                <tr class="evenRow">
                    <td align="left"><label for="down_percent">Percentage Down:</label></td>
                    <td><input type="text" size="5" name="down_percent" id="down_percent" value="<?php echo $_POST['down_percent']; ?>">%
                    </td>
                </tr>
                <tr class="oddRow">
                    <td align="left"><label for="year_term">Length of Mortgage:</label></td>
                    <td><input type="text" size="3" name="year_term" id="year_term" value="<?php echo $_POST['year_term']; ?>">years
                    </td>
                </tr>
                <tr class="evenRow">
                    <td align="left"><label for="annual_interest_percent">Annual Interest Rate:</label></td>
                    <td><input type="text" size="5" name="annual_interest_percent" id="annual_interest_percent" value="<?php echo $_POST['annual_interest_percent']; ?>">%
                    </td>
                </tr>
                <tr class="oddRow">
                    <td align="left"><label for="show_progress">Explain Calculations:</label></td>
                    <td><div class="icheckbox_square-blue checked" style="position: relative;"><input type="checkbox" name="show_progress" id="show_progress" value="1" style="width:auto;float:left;height: auto;" <?php echo $_POST['show_progress'] == 1 ? 'checked' : ''; ?> >  Show me the calculations and amortization</div>
                    </td>
                </tr>

                <tr height="15">
                    <td colspan="2"></td>
                </tr>
                
                <tr>

                    <td colspan="2" class="buttonBar">
                        <input name="submitFrm" type="submit" value="Calculate" class="button" >

                        <input type="button" value="Reset" class="button" onclick="location.href=''"></td>
                </tr>
                <?php if(isset($_POST) && !empty($_POST['sale_price']) &&  !empty($_POST['year_term']) && !empty($_POST['annual_interest_percent'])) { ?>

                <?php 
                    $homePrice = $_POST['sale_price'];
                    $downPresentage = $_POST['down_percent'] > 0 ? (float)($_POST['down_percent']): 0;
                    $downPay = (float)($downPresentage * $_POST['sale_price'])/100;
                    $annual_interest_percent = (float)$_POST['annual_interest_percent'];
                    $intRate = (float)$_POST['annual_interest_percent']/12/100;
                    $term = (int)$_POST['year_term'];
                    $months = $term*12;

                    $loanPrincipal = ($homePrice - $downPay);
                    $monthlyPayment = $loanPrincipal * $intRate * (pow(1 + $intRate, $months) / (pow(1 + $intRate, $months) - 1));

                    $pmi = (55/100000)*$loanPrincipal; //$55 per 100000
                ?>
                    <tr valign="top">
                        <td class="subHeading" colspan="2">Mortgage Payment Information</td>
                    </tr>
                    <tr class="oddRow">
                        <td align="left">Down Payment:</td>
                        <td><b>$<?php echo number_format($downPay,2  );?></b>
                        </td>
                    </tr>
                    <tr class="evenRow">
                        <td align="left">Amount Financed:</td>
                        <td><b>$<?php echo number_format($loanPrincipal,2  );?></b>
                        </td>
                    </tr>
                    <tr class="oddRow">
                        <td align="left">Monthly Payment:</td>
                        <td><b>$<?php echo number_format($monthlyPayment,2  );?></b><br><font>(Principal &amp; Interest ONLY)</font></td>
                    </tr>
                        <tr valign="top" class="noted">
                            <td align="right">&nbsp;</td>
                            <td>
                                <br>
                                Since you are putting LESS than 20% down, you will need to pay PMI (Private
                                Mortgage Insurance), which tends to be about $55 per month for every
                                $100,000 financed (until you have paid off 20% of your loan). This could
                                add
                                $<?php echo number_format($pmi, 2); ?>                                to your monthly payment.
                            </td>
                        </tr>
                        <tr valign="top" class="subtotal">
                            <td align="left">Monthly Payment:</td>
                            <td><b>$<?php echo number_format($monthlyPayment + $pmi,2  );?></b><br><font>(Principal &amp; Interest, and PMI)</font></td>
                        </tr>
                   
                    <tr valign="top" class="total">
                        <td align="left">TOTAL Monthly Payment:</td>
                        <td><b>$<?php echo number_format($monthlyPayment + $pmi + ($monthlyPayment*13.693796/100),2  );?></b><br><font>(including PMI and                                 residential tax)</font></td>
                    </tr>

                    

                <?php } ?>
                </tbody>
                                
            </table>
        </form>
                <br/><br/><br/>
        <?php if($_POST['show_progress'] == 1 && !empty($monthlyPayment)) { ?>
            <table class="resTable" cellpadding="5" cellspacing="0" border="1" width="100%">
                <tbody><tr valign="top">
                    <td><b>1</b></td>
                    <td>
                        The <b>down payment</b> = The price of the home multiplied by the percentage down divided by 100 (for 5%
                        down becomes 5/100 or 0.05)<br><br>
                        $<?php echo number_format($homePrice*($downPresentage/100)); ?> =
                        $<?php echo number_format($homePrice); ?> X
                        (<?php echo $downPresentage; ?> / 100)
                    </td>
                </tr>
                <tr valign="top">
                    <td><b>2</b></td>
                    <td>
                        The <b>interest rate</b> = The annual interest percentage divided by 100<br><br>
                        <?php echo  (float)($anualIntrestRate = ($annual_interest_percent/100)) ;?>= <?php echo $annual_interest_percent; ?>% /
                        100
                    </td>
                </tr>
                <tr valign="top" class="noted">
                    <td colspan="2">
                        The <b>monthly factor</b> = The result of the following formula:
                    </td>
                </tr>
                <tr valign="top">
                    <td><b>3</b></td>
                    <td>
                        The <b>monthly interest rate</b> = The annual interest rate divided by 12 (for the 12 months in a
                        year)<br><br>
                        <?php echo $monthlyIntrestRate = $anualIntrestRate/12; ?> = <?php echo $anualIntrestRate; ?> /
                        12
                    </td>
                </tr>
                <tr valign="top">
                    <td><b>4</b></td>
                    <td>
                        The <b>month term</b> of the loan in months = The number of years you've taken the loan out for times 12<br><br>
                        <?php echo $months; ?> Months
                        = <?php echo $term; ?> Years X 12
                    </td>
                </tr>
                <tr valign="top">
                    <td><b>5</b></td>
                    <td>
                        The monthly payment is figured out using the following formula:<br>
                        Monthly Payment = <?php echo $loanPrincipal;?> *
                        (<?php echo $monthlyIntrestRate;?> / (1 - ((1
                        + <?php echo $monthlyIntrestRate;?>                )<sup>-(<?php echo $months; ?>)</sup>)))
                        <br><br>
                        The <a href="#amortization">amortization</a> breaks down how much of your monthly payment goes towards
                        the bank's interest, and how much goes into paying off the principal of your loan.
                    </td>
                </tr>
            </tbody></table>

                                    <br/><br/><br/><br/>
            <a id="amortization"></a>Amortization For Monthly Payment: <b>$<?php echo number_format($monthlyPayment, 2); ?></b>  over <?php echo $term; ?> years
            <br/>
            <table cellpadding="5" cellspacing="0" class="amortization" border="1" width="100%">
            <?php 
            $remainingPrinciple = $loanPrincipal;
            for($i = 1; $i <= $term ; $i++){ ?>
                <tbody><tr valign="top" class="noted">
                    <td align="right"><b>Month</b></td>
                    <td align="right"><b>Interest Paid</b></td>
                    <td align="right"><b>Principal Paid</b></td>
                    <td align="right"><b>Remaining Balance</b></td>
                </tr>
                <?php 
                $spendinYear = $monthlyPayment * 12 ;
                $totalIntrestYear = $totalPrincipalYear = 0;
                for($j = 1; $j <= 12; $j++){ ?>
                <?php
                    $monthlyIntrest = ($intRate)*$remainingPrinciple;  
                    $totalIntrestYear +=   $monthlyIntrest;
                    
                    $monthlyPrincipalPaid = $monthlyPayment - $monthlyIntrest;
                    $totalPrincipalYear +=   $monthlyPrincipalPaid;
                    $remainingPrinciple = $remainingPrinciple - $monthlyPrincipalPaid;
                ?>
                <tr valign="top" class="common">
                    <td align="right"><?php echo ($i-1)*12+$j; ?></td>
                    <td align="right">$<?php echo number_format($monthlyIntrest, 2); ?></td>
                    <td align="right">$<?php echo number_format($monthlyPrincipalPaid, 2); ?></td>
                    <td align="right">$<?php echo number_format($remainingPrinciple, 2); ?></td>
                </tr>
                <?php } ?>
                
                <tr valign="top" class="subhead">
                    <td colspan="4"><b>Totals for year <?php echo $i; ?></b></td>
                </tr>
                <tr valign="top" class="totals">
                    <td>&nbsp;</td>
                    <td colspan="3">
                        You will spend $<?php echo number_format($spendinYear, 2); ?> on your house in year 1<br>
                        $<?php echo number_format($totalIntrestYear, 2); ?> will go towards INTEREST<br>
                        $<?php echo number_format($totalPrincipalYear, 2); ?> will go towards PRINCIPAL<br>
                    </td>
                </tr>
                <tr valign="top" class="blank">
                    <td colspan="4">&nbsp;<br><br></td>
                </tr>
            <?php } ?>
                
            </tbody></table>


            <?php } ?>

            
</div>


<?php //get_footer(); ?>