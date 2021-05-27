/**
* @param window
* @returns {digitalDataLayer}
*/
function digitalDataLayer(window) {
   'use strict';

   var isDefaultDigitalData = true;
   /**
    * This is the base skeleton of the digitalData and should be used as a reference to understand expected KEYs to use
    * when passing values to the digitalData.
    */
   this.defaultDigitalData = {
     "pageInstanceID": "",
     "user" : {
       /*This FORM section is to be reserved for collecting form submission data. PII values need to be encoded*/
       "form": {
           "creditRating": "",                         //example: Good - Collect the verbal rating instead of the numeric rating.
           "downPayment": "",                          //example: 15000 - value without comas or dollar signs
           "email": "",
           "estimatedMonthlyPayment": "",              //example: 1200 - value without comas or dollar signs
           "firstName": "",
           "homeDescription": "",                      //example: condo, townhouse, etc... AKA - Property Type
           "lastName": "",
           "phoneNumber": "",                          //example: 15559868855 - Number without additional characters
           "propertyUse": "",                          //example: Rental - Use of property
           "purchasePrice": "",                        //example: 203000 - value without comas or dollar signs
           "purpose" : "",                             //example: Refinance
           "zipcode": ""                               //example: 48226
       },
       /*This ATTRIBUTE section is for populating available user data after sign on*/
       "attributes": {
         "cellPhoneNumber" : "",                       //Populalate key with user cell phone number. example: 3133734000
         "closingDate" : "",
         "firstName" : "",
         "lastName" : "",
         "loanChannel" : "",                           //example: Forward
         "loanNumber" : "",                            //example: 3240942039
         "loanPurpose" : "",                           //example: Refinance
         "loanStatus" : "",                            //example: 21
         "numberOfMissedPayments" : "",
         "propertyAddressState" : "",                  //example: LA - The state or provence where the customer's property is located - Might not be the same as where they live.
         "rocketAccountId" : "",
         "maturityDate":"",                            //Loan maturity date from Servising - When the loan is paid off.
         "submitRefer" : "",                           //example: submit OR refer - The user either submits or refers an application.
         "userID" : "",                                //example: TestCoBoExp01.4k9j3eid@mailosaur.io - Likely to be the customer's email address.
         "userState" : "",                             //example: MI - The state or provence where the customer lives.
         "userType" : "",                              //example: Borrower
         "userZip" : ""                                //example: 48226
       }
     },
     "page": {
       "attributes": {
         "campaignCode": "",                           //Populalate key with page campaign code. example: RBA_rocketme.0000000013
         "channel": "",                                //Populalate key with page channel. example: rocket origination:home
         "creditRating":"",                            //example: Good - Collect the verbal rating instead of the numeric rating.
         "mortgageGoal":"",
         "loanNumber" : "",                            //example: 3240942039
         "loanPurpose" : "",                           //example: Refinance
         "leadTypeCode":"",
         "partnerCode":"",                             //Populalate key with page patner code. example: RBA
         "siteCode": "",                               //Populalate key with page sitecode. example: rocket
         "insurerID": ""                               //Populalate key with page insurer id. example: statefarm
       },
       "category": {"primaryCategory": ""},            //Populalate key with QL Blog - category of section
       "pageInfo": {
         "destinationURL": "",                         //current HREF of the active page.
         "hash": "",                                   //Populalate key with the URL's hash value.
         "host":"",                                    //current hostname per the domain
         "metricsID": "",                              //Populalate key with value of the Cookie - metricsid
         "pageName": "",                               //Populalate key with structured page reporting value consisting of the brand and page folders. example: ql:home loans:adjustable rate mortgage
         "pageType": "",                               //Populalate key with page type. example: Normal
         "path": "",                                   //Populalate key with document.location.pathname example: /l2/bam
         "previousPagename": "",                       //THIS SHOULD BE HANDLED WITH INTERNAL ADOBE PLUGIN - getPreviousPageName()
         "queryParameters":{},                         //example "qlsource" parameter with "applynow" value - inject key value pairs into this Object
         "queryString":"",                             //full string value of the location.search
         "referringURL": ""                            //Populalate key with page info referring url. example: "https://www.google.com/
       }
     }
   };
   /**
    * Condition to see if part of the Core structure of the digitalData has already been set.
    * This will prevent augmented values in the core structure to be overwritten.
    */
   if(this.readDataPoints(window.digitalData,"digitalData","pageName") != ""){
     isDefaultDigitalData = false;
   }
   // Enforce a singleton pattern.
   this.digitalData = window.digitalData || this.defaultDigitalData;
   window.digitalData = this.digitalData;

   this.previousPageName = sessionStorage.previousPageName;

   // Populate if object is new.
   if (isDefaultDigitalData) {
     this.setCoreDataLayer();
   }

   // Sets the previous page name, order of this matters
   this.setPreviousPageName();

   return this;
 };

 /**
  * Core structure of the data layer, anything app specific should go outside of this
  */
 digitalDataLayer.prototype.setCoreDataLayer = function () {
   var sd = this.setData.bind(this),
   leadDataCookie = this.getCookieByName('Lead_Data');

   if(leadDataCookie){
      leadDataCookie = JSON.parse(decodeURIComponent(leadDataCookie));
      for(var x in leadDataCookie){
        var trackX = "";
        if(leadDataCookie.hasOwnProperty(x)){
          trackX = x.charAt(0).toLowerCase()+x.slice(1);
          sd('page.attributes.'+trackX, leadDataCookie[x]);
        }
      }
      sd('page.attributes.loanPurpose', this.getLoanPurpose(leadDataCookie));
      sd('page.attributes.mortgageGoal', this.getMortgageGoal(leadDataCookie));
   }

   sd('pageInstanceID', document.title + ' - ' + document.location.hostname);
   sd('page.attributes.siteCode', this.getSiteCode());
   sd('page.attributes.channel', this.getChannel());
   sd('page.attributes.campaignCode', this.getCampaignCode());
   sd('page.attributes.partnerCode', this.getPartnerCode());
   sd('page.category.primaryCategory', this.getPageCategoryFromURL());

   // Default to normal
   sd('page.pageInfo.pageType', this.getPageType());
   sd('page.pageInfo.destinationURL', document.location.href);
   sd('page.pageInfo.referringURL', document.referrer);
   sd('page.pageInfo.pageName',  this.getPageName());
   sd('page.pageInfo.previousPagename', this.getPreviousPageName());
   sd('page.pageInfo.metricsID', this.getMetricsID());

   // Added features
   sd('page.pageInfo.hash', document.location.hash);
   sd('page.pageInfo.queryString', document.location.search);
   sd('page.pageInfo.path', document.location.pathname);
   sd('page.pageInfo.queryParameters', this.parseQueryStringToDictionary());
   sd('page.pageInfo.host', document.location.hostname);
 };

 /**
  * @returns {*}
  */
 digitalDataLayer.prototype.parseQueryStringToDictionary = function () {
   var queryString = document.location.search;
   var dictionary = {};

   // if it exists, remove the '?' from the beginning of the
   if (queryString.indexOf('?') === 0) {
     queryString = queryString.substr(1);
     // separate out each key/value pair
     var parts = queryString.split('&');

     for(var i = 0; i < parts.length; i++) {
       var p = parts[i];
       // Split Key/Value pair
       var keyValuePair = p.split('=');

       // Add Key/Value pair to Dictionary object
       var key = keyValuePair[0];
       var value = keyValuePair[1];

       // decode URI encoded string
       value = decodeURIComponent(value);
       value = value.replace(/\+/g, ' ');
       dictionary[key] = value;
     }
   }
   return dictionary;
 };

 /**
  * SETS the pageName based on the suffix value provided from the call durring the progress of an SPA.
  * The SPA only needs to provide an appropriate value to be appended to the otherwise natural value of the pageName.
  * Value is applied directly to the digitalData.page.pageInfo.pageName
  * @param {string} pnVal REQUIRED
  *
  */
 digitalDataLayer.prototype.setPageName = function (pnVal) {
   this.setData('page.pageInfo.pageName', this.getPageName(pnVal));
 }

 /**
  * GETS the page name base on the url structure.
  * The siteCode & pageType are passed to getPagePrefix and returned to serve as the prefix to the pageName.
  * The optional pnVal parameter is appended to the pageName value and is ideal for SPAs that do not augment the URL.
  * @param {string} pnVal OPTIONAL
  * @returns {string}
  * @example
  * URL -> https://qlmortgageservices.com/my/new/house-payment/
  * Prefix -> qlms
  * pnVal -> paid
  * Result -> "qlms:my:new:house payment:paid"
  */
 digitalDataLayer.prototype.getPageName = function (pnVal) {
   if(!!pnVal){this.setData('page.pageInfo.pageNameSuffix', pnVal)}
   /*
   In the case the pnVal is provided, but subsequently getPageName is called elsewhere without the parameter,
   we want the previously supplied suffix value to reflect in the pageName.
   */
   var pnVal = (!!pnVal)
     ?":"+pnVal
     :(this.digitalData.page.pageInfo.hasOwnProperty("pageNameSuffix"))
     ?":"+this.digitalData.page.pageInfo.pageNameSuffix
     :"";

   var pathVal = lpn = document.location.pathname+pnVal;
   var hashVal = document.location.hash;
   var siteCode = this.getSiteCode();
   var pageType = this.getPageType();
   var channelPath = this.getChannel();

  /*updating the pathVal when at the website root & there is NO hash value*/
  if(pathVal === '/' && !hashVal){
     pathVal = "/home";
  /*updating the pathVal if a hash value might be present*/
   } else {
     pathVal += hashVal.replace(/#/g, ":").replace(/!/g, "").split('?')[0];
   }
   /*updating the pathVal concerning BizDev URL structure*/
   if (channelPath.indexOf("BizDev") != -1) {
     pathVal = (lpn == "/" || lpn == '/partner/main/') ? "/home/"+pathVal : lpn;
   }
   /*updating the pathVal concerning agent x URL value exception*/
   if (siteCode == "agent x") {
     if (!hashVal && lpn.indexOf("agentconfidence") != -1) {
       pathVal = "AgentLP";
     }
   }
   /*updating the pathVal concerning qlms URL structure*/
   if (siteCode == "qlms") {
     if (lpn.indexOf("view") != -1 || lpn.indexOf("build") != -1) {
       pathArray = lpn.split("/");
       pathVal = (lpn.indexOf("build") != -1) ? pathArray[pathArray.length - 1] : pathArray[pathArray.length - 2];
     }
   }
   /*updating the pathVal concerning blog URL structure to ensure duplicate values are stripped out*/
   if (pageType == "blog") {
     var queryObject = this.readDataPoints(this.digitalData,"digitalData","pageURL");
     if (!!queryObject && queryObject.indexOf("blog") != -1) {
       pathVal = ":amp:" + queryObject.split('/blog')[1];
     }
   }
   /*updating the pathVal concerning URL structures that contain trailing numeric values*/
  if ( pathVal.indexOf("upload") != -1 || pathVal.indexOf('esign/review') != -1){
      pathVal = pathVal.replace(/:\d+$/, "");
  }
  /*updating the pathVal concerning new/esign URL structures that require the document name appended*/
  if ( pathVal.indexOf('new/esign') != -1) {
      pathVal = pathVal.replace(/\/\d+_\d+_\d+$/, "") +"/"+ this.getEsignDocumentName();
  }

  /*String Cleaning*/
   pathVal = pathVal.split("access_token")[0];
   pathVal = (pageType!="servicing")?pathVal.replace(/[0-9]{8,}(\b)/g, ''):pathVal;
   /*Final processing and String Cleaning*/
   pathVal = pathVal.replace(/(\/l\d?\/)|(\/alf\/)/gi, "/lander/")
     .replace(/\/\w{8}\-\w{4}\-\w{4}\-\w{4}\-\w{12}/g, "")
     .replace(/^\/|\/$/g, '')
     .replace(/\//g, ':')
     .replace(/-/g, " ");
   return (this.getPagePrefix(channelPath) + ":" + pathVal).replace(/(:){2,}/gi,":");
 };

 /**
  * The getChannel combines the value of the siteCode and pageType. If pageType has no value, then only the siteCode value is returned.
  * @returns {string}
  * @example siteCode = "rocket" & pageType = "origination" returns "rocket origination"
  */
 digitalDataLayer.prototype.getChannel = function () {
   var siteCode = this.getSiteCode();
   var pageType = this.getPageType();
   return (!!pageType)?siteCode+" "+pageType:siteCode;
 };

 /**
  * The getPagePrefix only contains values that need to be converted and returned. All other values compaired
  * will simply be processed and returned. The channelPath parameter is the combined value of the siteCode and pageType.
  * @param {string} channelPath
  * @returns {string}
  * @example "rocket origination" returns "rocket:origination"
  * @example "BizDev lander" returns "vip"
  */
 digitalDataLayer.prototype.getPagePrefix = function(channelPath){
   var pnPrefix = {
     "agent insight":"ai",
     "agent x":"ai",
     "agent":"ai",
     "BizDev":"vip",
     "BizDev lander":"vip",
     "BizDev blog":"vip",
     "BizDev proper":"vip",
     "BizDev thank you":"vip",
     "dashboard":"rocket:dashboard",
     "edison lander":"edison",
     "ql lander":"ql",
     "ql proper":"ql",
     "ql blog":"ql",
     "ql blog amp":"ql",
     "ql thank you":"ql",
     "ql:l2":"ql",
     "ql l2 thank you":"ql",
     "ql confidence":"ql",
     "rocket mortgage unauthenticated":"rocket",
     "rocket:finicity":"rocket",
     "rocket lander":"rocket",
     "rocket homes":"rockethomes",
     "rocket homes lander":"rockethomes",
     "rhq":"rockethq",
     "rocket hq":"rockethq",
     "rocket pro":"rocket:professional",
     "professional":"rocket:professional"
   };
   return (pnPrefix.hasOwnProperty(channelPath))?pnPrefix[channelPath]:(channelPath.indexOf("qlms") != -1)?"qlms":channelPath.replace(" ",":");
 }

 /**
  * Get pageType value.
  *
  * @returns {string}
  */

 digitalDataLayer.prototype.getPageType = function () {
   var pageType = "";

   // Site codes mapped to regular expressions (regex)
   var pageTypes = [
     {
       pageType: "dashboard",
       pattern: /^(.*dashboard.*?.rocketmortgage.com.*)$/
     },{
       pageType: "origination",
       pattern: /^(.*origination.*.rocketmortgage.com.*|.*origination.rocket.localhost.*)$/
     },{
       pageType: "servicing",
       pattern: /^(servicing.rocketmortgage.com.*)|(.*servicing.+?.rocketmortgage.com.*)$/
     },{
       pageType: "application",
       pattern: /(.*?rocketmortgage.com.+(.*refinance.*|.*purchase.*|.*application.*))/
     },{
       pageType: "thank you",
       pattern: /^(.*thank.*you.*)$/
     },{
       pageType: "info-seeker-landing",
       pattern: /^(portal.*?.rocketmortgage.com.*)$/
     },{
       pageType: "info-seeker",
       pattern: /^(explore-purchase.*?.rocketmortgage.com.*)|(explore-refinance.*?.rocketmortgage.com.*)$/
     },{
       pageType: "account",
       pattern: /^(.*rocketaccount.com.*)|(.*client-auth-login.*)$/
     },{
       pageType: "lmb",
       pattern: /^(.*veterans.quickenloans.com)|(.*mortgage.quickenloans.com)|(.*quickenloansreviews.com)|(.*quickenloansmortgage.com)|(.*quickenhomeloans.com)|(.*quickenloansrate.com)|(.*lowermybills.com.*)$/
     },{
       pageType: "blog",
       pattern: /^(.*\/blog\/.*)$/
     },{
       pageType: "learn",
       pattern: /^(.*\/learn\/.*)$/
     },{
       pageType: "unknown",
       pattern: /^localhost/
     },{
       pageType: "instapage",
       pattern: /^(.*instapage.*)|(\/i\d?\/)|(\/partner\-package\-ps1)$/
     },
     {
       pageType: "homes lander",
       pattern: /(.*www.rockethomes.com.*\/l\d?\/.*).*$/
     },
     {
       pageType: "homes",
       pattern: /(.*www.rockethomes.com).*$/
     },
     {
       pageType: "lander",
       pattern: /(.*\/l\d?\/.*)|(.*\/alf\/.*)$/
     },
     {
       pageType: "proper",
       pattern: /(.*www\.quickenloans.com.*)$/
     },
     {
       pageType: "org",
       pattern: /(.*www\.quickenloans.org.*)$/
     },
     {
       pageType: "hq",
       pattern: /(.*rockethq.*).*$/
     },
     {
       pageType: "loans",
       pattern: /(.*rocketloans.com.*)/
     },
     {
       pageType: "mortgage unauthenticated",
       pattern: /(www.*rocketmortgage.com.*)/
     },
     {
       pageType: "homes",
       pattern: /(.*rockethomes.*).*$/
     },
     {
       pageType: "none",
       pattern: /(.*realestateagent.*).*$/
     },
     {
       pageType: "qlms",
       pattern: /(.*qlmortgageservices.com.*)|(.*four51ordercloud.*)$/
     }
   ];

     if (document.location.href) {
       // Loop through and find a matching regex
       var refParts = document.location.hostname + document.location.pathname
       for (var idx in pageTypes) {
         var regExArray = pageTypes[idx].pattern.exec(refParts);
         if (regExArray) {
           // Found matching pageType
           pageType = pageTypes[idx].pageType;
           break;
         }
       }
       if (pageType == "qlms") {
         var pTypeDefault = (document.location.pathname).split("/");
         pageType = pTypeDefault[1];
       }
     }
   return (pageType == "none")?"":pageType;
 }
 // Gets the site code of the app you are on based on the url
 /**
  * Get single siteCode value.
  *
  * @returns {string}
  */
 digitalDataLayer.prototype.getSiteCode = function () {
   var siteCode = "";

   // Site codes mapped to regular expressions (regex)
   var siteCodes = [
     {
       siteCode: "fsbo",
       pattern: /^(.*forsalebyowner.*?)/gi
     },
     {
       siteCode: "edison",
       pattern: /^(.*trusted.ca.*)|(\/easy-start\/?)/gi
     },
     {
       siteCode: "professional",
       pattern: /^(.*rocketprofessional.com.*)|(.*licenseproui.licensepro.*)$/
     },
     {
       siteCode: "rocket",
       pattern: /(.*rocket[amph]+.*)|(.*sso.rock.*)|(.*bmfoc.zone.*|.*ai\.foc.zone.*)/gi
     },
     {
       siteCode: "agent x",
       pattern: /^(.*realestateagent.*)$/
     },
     {
       siteCode: "BizDev",
       pattern: /^(.*insider.*)|(.*bizdev.*)|(\/partner\/|\/insider\/)$/
     },
     {
       siteCode: "qlms",
       pattern: /(.*qlmortgageservices.com.*)|(.*four51ordercloud.*)$/
     },
     {
       siteCode: "ql",
       pattern: /(.*quickenloans\.(com)|(org)).*$/
     },
     {
       siteCode: "myql",
       pattern: /(.*myql.com)|(\/myql\/|insider\/)$/
     }
   ];

   try {
     if (document.location.hostname) {
       // Loop through and find a matching regex
       var refParts = document.location.hostname + document.location.pathname
       for (var idx in siteCodes) {
         var regExArray = siteCodes[idx].pattern.exec(refParts);
         if (regExArray) {
           // Found matching sitecode
           siteCode = siteCodes[idx].siteCode;
           break;
         }
       }
       /* Check if we ever made a match*/
       if (!siteCode) {
         var sCodeDefault = (document.location.hostname=="localhost")?("www.localhost.com").split("."):(document.location.hostname).split(".");
         siteCode = sCodeDefault[sCodeDefault.length-2];
       }
     }
   } catch (e) {}

   return siteCode;
 };

 digitalDataLayer.prototype.getEsignDocumentName = function(){
  var docNameElement = document.querySelector('[data-document-name]'),
    docName;
  if(docNameElement){
   documentSelected = docNameElement.getAttribute('data-document-name');
    if(documentSelected){

      if(documentSelected.split(' - ').length > 1){
        documentSelected = documentSelected.split(' - ')[0];
      }
      else{
        documentSelected = documentSelected.split('|')[0];
      }
    }
  }
  if(typeof documentSelected !== 'undefined' && documentSelected.length >= 1){
    return documentSelected;
  } else {
    return "";
  }
}

 digitalDataLayer.prototype.getCookieByName = function (name) {
   var value = "; " + document.cookie;
   var parts = value.split("; " + name + "=");
   if (parts.length == 2) return parts.pop().split(";").shift();
 };

 digitalDataLayer.prototype.getMetaByName = function (_metaName) {
   if ((typeof document.querySelector === 'function') && (typeof _metaName === 'string')) {
     var elem = document.querySelector("meta[name='" + _metaName.toString() + "']");
     if ((elem) && (typeof elem.content === 'string')) {
       var retVal = elem.content;
       return retVal;
     }
   }
 };

 digitalDataLayer.prototype.getQueryStringByName = function (_qsName, caseInsensitve) {
   var decoder, match, qsName, query, pl, search, urlParams;

     pl = /\+/g; // Regex for replacing addition symbol with a space
     search = /([^&=]+)=?([^&]*)/g;
     decoder = function(s) {
       return decodeURIComponent(s.replace(pl, " "));
     };
     query = document.location.search.substring(1);
     qsName = _qsName.toString();
     urlParams = {};

   while (match = search.exec(query)) {
     if (!!caseInsensitve) {
         urlParams[decoder(match[1].toLowerCase())] = decoder(match[2]);
     } else {
         urlParams[decoder(match[1])] = decoder(match[2]);
     }
   }

   return urlParams[qsName];
 };

 digitalDataLayer.prototype.getCampaignCode = function () {
   var qls, qlsQuery, qlsCookie;
   //check the query string first - otherwise check for qls cookies or qls metas
   qlsQuery = this.getQueryStringByName('qls', 1);
   qlsCookie = this.getCookieByName('qls');
   qls = (!!qlsQuery)?qlsQuery:(!!qlsCookie)?qlsCookie:"";

   return qls;
 };

 /**
  * Get 3 character partner code.
  *
  * @returns {string|null}
  * @example "MKZ"
  */
 digitalDataLayer.prototype.getPartnerCode = function () {
   var partnerCode;

   partnerCode = this.getCampaignCode();

   return (!!partnerCode && partnerCode.length > 2)?partnerCode.slice(0,3):null;
 };
 /**
  * Get getMetricsID from cookie.
  *
  * @returns {string|null}
  */
 digitalDataLayer.prototype.getMetricsID = function () {
   return this.getCookieByName('metricsid')
 };

 /**
  * Get the page category based on the url.
  *
  * @returns {string|null}
  * @example "home-buying" returns "purchase"
  */
 digitalDataLayer.prototype.getPageCategoryFromURL = function () {
   var search = /(refinance|purchase|home-buying|harp)/gi,
     query = document.location.pathname,
     retVal="",
     match;

   while (match = search.exec(query))
     retVal = match[1];
   switch (retVal) {
     case 'purchase':
       return 'Purchase';
       break;
     case 'refinance':
       return 'Refinance';
       break;
     case 'home-buying':
       return 'Purchase';
       break;
     case 'harp':
       return 'Refinance';
       break;
     default:
       break;
   }

   return retVal;
 };

 /**
  * Set previous page name and set to local storage.
  *
  */
 digitalDataLayer.prototype.setPreviousPageName = function () {
   if( Storage ) {
     sessionStorage.previousPageName = this.getPageName();
   }
 };

 /**
  * GET previous page name in local storage.
  *
  * @returns {string|null}
  */
 digitalDataLayer.prototype.getPreviousPageName = function () {
   return sessionStorage.previousPageName;
 };

 /**
  * GET Loan Purpose from Lead Data cookie value.
  *
  * @param {object} leadData
  * @returns {string|null}
  * @example "home buying" returns "purchase"
  */
 digitalDataLayer.prototype.getLoanPurpose = function (leadData) {

    var _loanPurpose;

    try {
      var loanPurpose = 'purchase';
      //Parse and format Loan Purpose
      switch (leadData.LoanPurpose.toLowerCase().replace(/\+/g, ' ')) {
        case 'purchase':
        case 'signed a purchase agreement':
        case 'making an offer within 30 days':
        case 'offer pending / found a house':
        case 'buying in 2 to 3 months':
        case 'hope to buy within 2-3 months':
        case 'purchasing within 45 days':
        case 'actively looking 45  days':
        case 'researching options':
        case 'home buying':
          loanPurpose = 'purchase'
          break
        case 'refinance':
        case 'debtconsolidation':
        case 'cashoutrefinance':
          loanPurpose = "refinance"
          break
        default:
          loanPurpose = leadData.LoanPurpose;
          break;
      }
      _loanPurpose = loanPurpose;
    } catch (error) {_loanPurpose = "n-a"}

      return _loanPurpose;
  }
  /**
   * GET Mortgage Goal from Lead Data cookie value.
   *
   * @param {object} leadData
   * @returns {string|null}
   * @example "refinance" returns "Mortgage Refinance"
   */
  digitalDataLayer.prototype.getMortgageGoal = function(leadData) {

    var _mortgageGoal;

    try {
      var mortgageGoal = 'purchase';

      switch (leadData.LoanPurpose.replace(/\+/g, ' ')) {
        case 'refinance':
          mortgageGoal = 'Mortgage Refinance';
          break
        case 'debtconsolidation':
          mortgageGoal = 'Debt Consolidation';
          break
        case 'cashoutrefinance':
          mortgageGoal = 'Cash-Out Refinance';
          break
        default:
          mortgageGoal = leadData.LoanPurpose.replace(/\+/g, ' ');
          break
      }

      _mortgageGoal = mortgageGoal.toLowerCase();
    } catch (error) {_mortgageGoal = "n-a"}

    return _mortgageGoal;
  }

 /**
  * For creating dynamic objects
  * This function uses recursion.
  * The concat param is a boolean used to determine if value will stack (true) or overwrite (false)
  *
  * @param {object} obj
  * @param {string} path
  * @param {string} val
  * @param {Boolean/Optional} concat
  */
 digitalDataLayer.prototype.mutate = function (obj, path, val, concat) {
   var head, tail;

   head = path[0];
   tail = path.slice(1);

   if (tail.length) {
     obj[head] = obj[head] || {};
     this.mutate(obj[head], tail, val, concat);
   } else {
     switch (typeof val) {
       case 'object':
         obj[head] = val; // this needs to be an object
         break;
       default:
         obj[head] += (obj[head]!="")?",":"";
         obj[head] = (concat)?obj[head]+val.toString():val.toString();
     }
   }
 };

 /**
  * Set a value on the digitalDataLayer. Will not set if the value is undefined.
  *
  * @param {string} path
  * @param {*} val Cannot be of type undefined.
  */
 digitalDataLayer.prototype.setData = function (path, val, concat) {

   // Only set the data on the object if we have something to set
   if (typeof this.digitalData !== 'object') {
       throw new Error('Missing, or invalid, storage object: ' + this.digitalData);
   }

   if (typeof val === 'undefined') {
       return false;
       throw new Error('type of val is: ' + typeof val);
   }

   if (typeof path !== 'string') {
     throw new Error('Missing, or invalid, path: ' + path);
   }

   this.mutate(this.digitalData, path.split('.'), val,concat);

   return true;
 };

 /**
  * Tracks form changes and adds them to the digitalDataLayer object.
  *
  * This would track all fields on a page that have the [data-dltrack] attribute.
  * For example: window.focDataLayer.trackFields(document);
  * Also this only tracks select and radio buttons, so no input/textareas.
  *
  * @param {document|HTMLelement} element any object that support the '.querySelectorAll' method.
  * @param {string} cssSelector defaults to: 'input, select, textarea'
  */
 digitalDataLayer.prototype.trackFields = function (element, cssSelector, optionsCustom) {
   var eventCallback, eventType, field, fields, key, getInitialValue, isVisible, nodeName, nodeType, selector, options;

   selector = cssSelector || '[data-dltrack]';

   options = {
     loadAuto: true,         // loads initial value on page load
     loadOnDisplay: false,   // loads initial value when element is visible (hidden inputs are always loaded initially)
     // TODO loadAutoWhitelist: [],  // list of fields to automatically load
     // TODO loadAutoBlacklist: [],  // list of fields to not automatically load (takes precedence)
   };
   // Merge options object
   if (optionsCustom !== null && typeof optionsCustom === 'object') {
     options = Object.assign(options, optionsCustom);
   }

   fields = element.querySelectorAll(selector);

   for (key in fields) {
     if (!fields.hasOwnProperty(key)) {
       continue;
     }

     field = fields[key];
     eventCallback = null;
     nodeName = field.nodeName.toLowerCase();
     nodeType = (typeof field.type !== 'undefined' ? field.type.toLowerCase() : undefined );
     getInitialValue = false;
     isVisible = !!(field.offsetWidth || field.offsetHeight || (typeof field.getClientRects === "function" && field.getClientRects().length) || field.offsetParent !== null);
     // Attach the change event listener to each field.
     // Hidden fields do not automatically trigger 'change' on value change.
     // Need to trigger 'change' event manually if you are updating a hidden field and want to track in digitalData
     //    $('input[@type="hidden"]').trigger('change');
     switch (nodeName + '-' + nodeType) {
       case 'select-select-one':
       case 'input-hidden':
       case 'input-radio':
       case 'input-checkbox':
         eventType = 'change';
         break;
       default:
         eventType = 'blur';
         break;
     }

     /* ---Prevent multiple event listener from being added to a single field.---
      CORRECTION - Latest versions of apps across the company sites are having issues
      where the element says tracking has been added, but is a false positive.
      TO DO:
      Find a better way to prevent false positives and check for them.
      Where is the disconnect that "trackingAdded" is applied but the bind
      fails to apply to the element - OR - How is an element losing what was bound?
     */
     if (!field.hasOwnProperty('trackingAdded')) {

       // Set event call back
       switch (nodeName + '-' + nodeType) {
         case 'input-radio':
           eventCallback = this.storeCheckedRadioFieldValue;
           break;
         case 'input-checkbox':
           eventCallback = this.storeCheckedFieldValue;
           break;
        default:
           eventCallback = this.storeFieldValue;
           break;
       }

       if (eventCallback !== null) {
         // Apply generic change listener
         field.addEventListener(eventType, eventCallback.bind(this));
         field.trackingAdded = true;

         if (options.loadOnDisplay) {
           // Apply field display listener
           field.addEventListener("visibilityChange", eventCallback.bind(this));

           // Look for intially displayed fields and get value
           if ((isVisible || nodeType === 'hidden') && hasValue(field)) {
             getInitialValue = true;
           }
         }

         // Sets the intial value if loadAuto flag is present.
         // Some fields are already set and the client may not change them.
         if ((options.loadAuto === true || nodeType === 'hidden') && hasValue(field)) {
           getInitialValue = true;
         }


         if (getInitialValue) {
           eventCallback.call(
             this,
             { "target": { "value":  field.value, "dataset": {"dltrack": field.dataset.dltrack}} }
           );
         }
       }
     }
   }
 };

 /**
  * Get a value from a select|radio button.
  *
  * @param field
  * @returns {boolean}
  */
 function hasValue (field) {
   var checkedField, hasVal;

   hasVal = false;

   switch (field.type) {
     case 'select-one':
     case 'hidden':
     case 'text':
     case 'email':
     case 'number':
     case 'tel':
       hasVal = field.value.length > 0;
       break;
     case 'radio':
       checkedField = document.querySelectorAll('[data-dltrack="' + field.dataset.dltrack + '"]:checked');
       hasVal = checkedField.length > 0 && checkedField[0].value.length > 0;
       break;
   }

   return hasVal;
 }

 /**
  *  Store a form field value in the data layer.
  *
  * @param evt
  */
 digitalDataLayer.prototype.storeFieldValue = function (evt) {
   this.setData('user.form.' + evt.target.dataset.dltrack, evt.target.value);
 };

 /**
  *  Store a form field value in the data layer.
  *
  * @param evt
  */
 digitalDataLayer.prototype.storeCheckedRadioFieldValue = function (evt) {
   var fields;

   fields = document.querySelectorAll('[data-dltrack="' + evt.target.dataset.dltrack + '"]:checked');
   if(fields.length >= 1){
     this.setData('user.form.' + fields[0].dataset.dltrack, fields[0].value);
   }

 };
 /**
  *  Store a form field value in the data layer.
  *
  * @param evt
  */
 digitalDataLayer.prototype.storeCheckedFieldValue = function (evt) {
   var fields;
   fields = document.querySelectorAll('[data-dltrack="' + evt.target.dataset.dltrack + '"]:checked');
   /*Check boxes can stack. First clear the values and then stack the :ckecked boxes :-) */
   this.setData('user.form.' + evt.target.dataset.dltrack, "");
   for(var l=0; l<fields.length; l++){
     this.setData('user.form.' + fields[l].dataset.dltrack, fields[l].value, true);
   }

 };
 /**
  * Inspect and Return child key of named object. The child can exist at any level of the object.
  * If the child is found then a value is returned else empty quotes.
  *
  * @param {object} nameSpace
  * @param {string} name
  * @param {string} dataPoint
  * @return {string|empty quotes}
  * @example readDataPoints(digitalData,"digitalData","pageName")
  */
 digitalDataLayer.prototype.readDataPoints = function(nameSpace,name,dataPoint,scope){
  var cText = "";
  var scopeText = (!!scope)?scope+"."+name:name;
  for(x in nameSpace){
    if(nameSpace.hasOwnProperty(x)){
      cText += (typeof nameSpace[x] == "object")?this.readDataPoints(nameSpace[x],x,dataPoint,scopeText):
      (dataPoint != x)?"":nameSpace[x]+"\n";
    }
  }
  return cText;
}

 if (typeof window === 'object') {
   // Initialize focDataLayer object and make it a global.
   window.focDataLayer = new digitalDataLayer(window);
 }

 // For compatibility with NodeJS.
 if (typeof module === 'object' && module.hasOwnProperty('exports')) {
   module.exports.dataLayer = digitalDataLayer;
 }
