(function(networkId) {
var cacheLifetimeDays = 1;

var customDataWaitForConfig = [
  { on: function() { return Invoca.Client.parseCustomDataField("calling_page_url", "Last", "JavascriptDataLayer", "window.location.pathname"); }, paramName: "calling_page_url", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("creative", "Last", "URLParam", ""); }, paramName: "creative", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("device", "Last", "URLParam", ""); }, paramName: "device", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("ef_id", "First", "URLParam", ""); }, paramName: "ef_id", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("gclid", "Last", "URLParam", ""); }, paramName: "gclid", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("g_cid", "First", "URLParam", ""); }, paramName: "g_cid", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("invoca_uid", "Unique", "JavascriptDataLayer", "Invoca.Tools.readInvocaData(\"invoca_id\")"); }, paramName: "invoca_uid", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("matchtype", "Last", "URLParam", ""); }, paramName: "matchtype", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("mcid", "First", "URLParam", ""); }, paramName: "mcid", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("qls", "Last", "URLParam", ""); }, paramName: "qls", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("qls_prefix", "Last", "JavascriptDataLayer", "Invoca.Client.qlsPrefix()"); }, paramName: "qls_prefix", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("ql_destination_number", "Last", "URLParam", ""); }, paramName: "ql_destination_number", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("tnt_campaign", "Last", "URLParam", "tnt_campaign"); }, paramName: "tnt_campaign", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("tnt_experience", "Last", "URLParam", "tnt_experience"); }, paramName: "tnt_experience", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("tnt_id", "First", "URLParam", "tnt_id"); }, paramName: "tnt_id", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("utm_campaign", "Last", "URLParam", ""); }, paramName: "utm_campaign", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("utm_content", "Last", "URLParam", ""); }, paramName: "utm_content", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("utm_medium", "Last", "URLParam", ""); }, paramName: "utm_medium", fallbackValue: function() { return Invoca.PNAPI.currentPageSettings.poolParams.utm_medium || null; } },
  { on: function() { return Invoca.Client.parseCustomDataField("utm_source", "Last", "URLParam", ""); }, paramName: "utm_source", fallbackValue: function() { return Invoca.PNAPI.currentPageSettings.poolParams.utm_source || null; } },
  { on: function() { return Invoca.Client.parseCustomDataField("utm_term", "Last", "URLParam", ""); }, paramName: "utm_term", fallbackValue: null },
  { on: function() { return Invoca.Client.parseCustomDataField("ver", "Last", "URLParam", ""); }, paramName: "ver", fallbackValue: null }
];

var defaultCampaignId = null;

var destinationSettings = {
  paramName: null
};

var numbersToReplace = null;

var organicSources = true;

var reRunAfter = null;

var requiredParams = null;

var resetCacheOn = ['gclid', 'qls'];

var waitFor = 0;

var customCodeIsSet = (function() {
  Invoca.Client.customCode = function(options) {
   try {

// [data-phone] content is automatically replaced by invoca with a phone number
// [data-phonelink] is to be used on link only elements that have content other than a phone number. This is not touched by invoca
function showNumber(mapping) {
  var numberResponse = null;

  if (mapping.length >= 1){
    // Assuming only the 1st element
    if (typeof mapping[0].formattedNumber !== 'undefined') {
      // Mapping contains a valid number
      numberResponse = mapping[0];
    }
  }
  
  // Check for any elements that has not been processed
  var $invocaPhoneLink = $("[data-phonelink]").hasClass('js-invocaLink');
  if (!$invocaPhoneLink) {
    $("[data-phonelink]").each( function(){
        $(this).addClass('js-invocaLink u-No-tel@md');

        // Only change if we have a number and it's a link
        if (numberResponse !== null && $(this).prop("tagName").toLowerCase() === 'a') {
            $(this).attr('href', formatPhoneLink(numberResponse.formattedNumber));
        }
    });
  }
  
  // Check for any elements that has not been processed
  var $invocaPhoneNumber = $("[data-phone]").hasClass('js-invocaLink');
  if (!$invocaPhoneNumber) {
    $("[data-phone]").each( function(){
        $(this).addClass('js-invocaLink u-No-tel@md');

        // Only change it's a link
        if ($("[data-phone]").prop("tagName").toLowerCase() === 'a') {
            $(this).attr('href', formatPhoneLink($(this).html()));
        }
    });
  }

  // Show elements
  $("[data-phone], [data-phonelink]").removeClass('u-Hide-if-js');
  $("[data-phone], [data-phonelink]").removeClass('u-Hide');
  $("[data-phone], [data-phonelink]").addClass('u-InlineBlock', 250);
  $("[data-phone], [data-phonelink]").parent("a, li").removeClass('u-Hide-if-js');
  
  if("[data-sprk-main]") {
    $("[data-phone], [data-phonelink]").removeClass('sprk-u-Display--none');
  }
}


//format link
function formatPhoneLink(phonenum) {
  phonenum = phonenum.replace(/[^0-9]+/g, '');
  phonenum = 'tel:' + phonenum;
  return phonenum;
}

//fix flashing
function showNumberDelay(mapping) {
  setTimeout(showNumber, 1000, mapping);
}

//ios big fix
function doInvocaAgain() {
  Invoca.PNAPI.doInvoca();
}

//delay a call to doInvocaAgain to fix IOS
//setTimeout(doInvocaAgain, 1000);

Invoca.Client.qlsPrefix = function() {
  var qls = Invoca.Tools.readUrl('qls');
  // Assign qls prefix to be the first few letters before "_"
  // If qls parameter is not present, assign default campaign id to be "QMM"
  return qls ? qls.split('_')[0] : "QMM";
};

// Grab first few letters of "qls" prior to "_" from URL query string
Invoca.Client.getDefaultCampaignId = function () {
  // LEGACY SOLUTION
  // Set campaign id to qlsPrefix as default
  var campaignId = Invoca.Client.qlsPrefix();
  
  // CONSOLIDATED SOLUTION
  // QLS prefixes to check for affiliate and servicing pages
  var affiliateValues = ["NAT", "MNT", "MVO", "CDT", "RFR"];
  var servicingValues = ["ESC", "DMP"];
  
  // If the first few letters before "_" is in the affiliateValues or servicingValues arrays, assign default campaign id to consolidated campaigns - destination number for these campaigns determined by lookup tables
  function checkValue(value) {
    return value == campaignId;
  }
  
  if(affiliateValues.some(checkValue)){
    campaignId = "affiliate";
  }else if(servicingValues.some(checkValue)){
    campaignId = "servicing";
  }
   
  return campaignId;
}

// Captures first letters in "qls" before the "_" to use as the Invoca Campaign Id
// If there's no "qls", on the page, Invoca will not run
var invocaCampaignId = Invoca.Tools.readInvocaData("invCampaignId", Invoca.Client.getDefaultCampaignId());

// Stores the Invoca Campaign Id from "qls" parameter for 1 day
//var invocaParams = {
  //invCampaignId: invocaCampaignId,
  //tnt_campaign: Invoca.Tools.readCookie("tnt_campaign"),
  //tnt_experience: Invoca.Tools.readCookie("tnt_experience"),
  //tnt_id: Invoca.Tools.readCookie("tnt_id")
//};

options.numberSelector = "[data-phone]";
// options.poolParams = Invoca.PNAPI.extend({}, options.poolParams, invocaParams);
//Adding to poolParams directly after migrating to custom data, remove 41-46, 50 after next revision
options.poolParams.invCampaignId = invocaCampaignId;
options.defaultCampaignId = invocaCampaignId; //Set campaign based on "qls parameter"

options.onComplete = showNumberDelay; // For number flashing

options.integrations = {
  googleAnalytics: true,

  adobeAnalytics: {
    username: "5D60123F5245B13E0A490D45@AdobeOrg", paramName: "mcid"
  }
};

return options;

   } catch (e) {
     Invoca.PNAPI.warn("Custom code block failed: " + e.message);
   }
  };

  return true;
})();

var generatedOptions = {
  autoSwap:            false,
  cookieDays:          cacheLifetimeDays,
  country:             null,
  defaultCampaignId:   defaultCampaignId,
  destinationSettings: destinationSettings,
  disableUrlParams:    [],
  doNotSwap:           [],
  maxWaitFor:          waitFor,
  networkId:           networkId || null,
  numberToReplace:     numbersToReplace,
  organicSources:      organicSources,
  poolParams:          {},
  reRunAfter:          reRunAfter,
  requiredParams:      requiredParams,
  resetCacheOn:        resetCacheOn,
  waitForData:         customDataWaitForConfig
};

Invoca.Client.startFromWizard(generatedOptions);

})(368);
