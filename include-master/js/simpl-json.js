// 日本語UTF-8, LF



// include



// define
const SIMPL__STRING__JSON__API_NAME__DEFAULT = "SIMPL";
const SIMPL__STRING__JSON__API_VERSION = "1.0000.0000";


const STRING__SIMPL__ELEMENT_ID__DEBUG_VIEW__JSON__REQUEST = "simpl__debug_view-JSON-Request"
const STRING__SIMPL__ELEMENT_ID__DEBUG_VIEW__JSON__RESPONSE = "simpl__debug_view-JSON-Response"



// global



// ===================================================================
// public
// -------------------------------------------------------------------

function SIMPL__GetVersion()
{
	return SIMPL__STRING__JSON__API_VERSION;
}


// -------------------------------------------------------------------
// asynchronous request


// subject  : send asynchronous request ( GET )
// argument : string, uri
// argument : object, json data
// argument : callback, on success ( eJSON_Response, eProgressEvent, eXHR )
// argument : callback, on error ( eString_URI, eJSON_Request, eProgressEvent, eXHR )
// return   : object, database entity
function SIMPL__SendRequest_JSON( eString_URI, eJSON_Request, fCallback_Success, fCallback_Error )
{
	var eXHR = new XMLHttpRequest();
	var eString_JSON = JSON.stringify( eJSON_Request );

	eXHR.open( "GET", ( eString_URI + "?JSON=" + encodeURIComponent( eString_JSON ) ), true );
	eXHR.onload = function ( eProgressEvent )
		{
			if (eXHR.readyState === 4)
			{
				if (eXHR.status === 200)
				{
					console.log( eXHR.responseText );
					var eJSON_Response = JSON.parse( eXHR.responseText );

					if ( fCallback_Success != null )
					{
						fCallback_Success( eJSON_Response, eProgressEvent, eXHR );
					}
					else
					{
						local_SIMPL__JSON__UpdateDebugView( eString_JSON, eXHR.responseText );
					}
				}
				else
				{
					if ( fCallback_Error != null )
					{
						fCallback_Error( eString_URI, eJSON_Request, eProgressEvent, eXHR );
					}
					else
					{
						console.error( "SendRequest - not 200 : " );
						console.error( eXHR.statusText );
						console.error( eString_URI );
						console.error( eJSON_Request );
					}
				}
			}
			else
			{
				console.log( eProgressEvent );
			}
		};
	eXHR.onerror = function ( eProgressEvent )
		{
			if ( fCallback_Error != null )
			{
				fCallback_Error( eString_URI, eJSON_Request, eProgressEvent, eXHR );
			}
			else
			{
				console.error( "SendRequest - onerror : " );
				console.error( eXHR.statusText );
				console.error( eString_URI );
				console.error( eJSON_Request );
			}
		};
	eXHR.onabort = eXHR.onerror;
	eXHR.ontimeout = eXHR.onerror;
	eXHR.send( null );
}


// subject  : send asynchronous request ( POST )
// argument : string, uri
// argument : object, json data
// argument : callback, on success ( eJSON_Response, eProgressEvent, eXHR )
// argument : callback, on error ( eString_URI, eJSON_Request, eProgressEvent, eXHR )
// return   : object, database entity
function SIMPL__PostRequest_JSON( eString_URI, eJSON_Request, fCallback_Success, fCallback_Error )
{
	var eXHR = new XMLHttpRequest();
	var eString_JSON = JSON.stringify( eJSON_Request );

	eXHR.open( "POST", eString_URI, true );
	eXHR.setRequestHeader( "Content-type", "application/x-www-form-urlencoded" );
	eXHR.onreadystatechange = function ( eProgressEvent )
		{
			if ( eXHR.readyState == XMLHttpRequest.DONE )
			{
				if ( eXHR.status == 200)
				{
					console.log( eXHR.responseText );
					var eJSON_Response = JSON.parse( eXHR.responseText );

					if ( fCallback_Success != null )
					{
						fCallback_Success( eJSON_Response, eProgressEvent, eXHR );
					}
					else
					{
						local_SIMPL__JSON__UpdateDebugView( eString_JSON, eXHR.responseText );
					}
				}
				else
				{
					if ( fCallback_Error != null )
					{
						fCallback_Error( eString_URI, eJSON_Request, eProgressEvent, eXHR );
					}
					else
					{
						console.error( "SendRequest - not 200 : " );
						console.error( eXHR.statusText );
						console.error( eString_URI );
						console.error( eJSON_Request );
					}
				}
			}
		}
	eXHR.onerror = function ( eProgressEvent )
		{
			if ( fCallback_Error != null )
			{
				fCallback_Error( eString_URI, eJSON_Request, eProgressEvent, eXHR );
			}
			else
			{
				console.error( "SendRequest - onerror : " );
				console.error( eXHR.statusText );
				console.error( eString_URI );
				console.error( eJSON_Request );
			}
		};
	eXHR.onabort = eXHR.onerror;
	eXHR.ontimeout = eXHR.onerror;
	eXHR.send( "JSON=" + encodeURIComponent( eString_JSON ) );
//	eXHR.send( "JSON=" + encodeURIComponent( eString_JSON ).replace( /%20/g, "+" ) );
}


// subject  : wait asynchronous requests and execute callback
// argument : array, requests
// argument : callback, callback
// return   : object, database entity
function SIMPL__WaitRequests_JSON( arRequests, fCallback )
{
	var iCountWait = arRequests.length;
	var aaWaits = {};

	for ( var i = 0; i < arRequests.length; i++ )
	{
		var aaRequest = arRequests[i];

		if ( aaRequest["URL"] )
		{
			switch ( aaRequest["Method"] )
			{
				case "GET":
					SIMPL__SendRequest_JSON
						( 
							aaRequest["URL"], 
							aaRequest["Request"], 
							function ( eJSON_Response, eProgressEvent, eXHR ) 
							{
								var iID = aaRequest["ID"];

								if ( aaRequest["Callback-Success"] != null )
								{
									aaRequest["Callback-Success"]( eJSON_Response, eProgressEvent, eXHR );
								}

								SIMPL__WaitRequests_JSON__Callback( iID, true, eJSON_Response, eProgressEvent, eXHR );
							}, 
							function ( eString_URI, eJSON_Request, eProgressEvent, eXHR ) 
							{
								var iID = aaRequest["ID"];

								if ( aaRequest["Callback-Error"] != null )
								{
									aaRequest["Callback-Error"]( eString_URI, eJSON_Request, eProgressEvent, eXHR ) 
								}

								SIMPL__WaitRequests_JSON__Callback( iID, false, eJSON_Response, eProgressEvent, eXHR );
							}
						);
					break;

				case "POST":
					SIMPL__PostRequest_JSON
						( 
							aaRequest["URL"], 
							aaRequest["Request"], 
							function ( eJSON_Response, eProgressEvent, eXHR ) 
							{
								var iID = aaRequest["ID"];

								if ( aaRequest["Callback-Success"] != null )
								{
									aaRequest["Callback-Success"]( eJSON_Response, eProgressEvent, eXHR );
								}

								SIMPL__WaitRequests_JSON__Callback( iID, true, eJSON_Response, eProgressEvent, eXHR );
							}, 
							function ( eString_URI, eJSON_Request, eProgressEvent, eXHR ) 
							{
								var iID = aaRequest["ID"];

								if ( aaRequest["Callback-Error"] != null )
								{
									aaRequest["Callback-Error"]( eString_URI, eJSON_Request, eProgressEvent, eXHR ) 
								}

								SIMPL__WaitRequests_JSON__Callback( iID, false, eJSON_Response, eProgressEvent, eXHR );
							}
						);
					break;
			}
		}
	}

	function SIMPL__WaitRequests_JSON__Callback( iID, bFlag_Success, eJSON_Response, eProgressEvent, eXHR )
	{
		SIMPL__DEBUG__Echo( [ iID, bFlag_Success ] );

		if ( aaWaits[iID] == null )
		{
			SIMPL__DEBUG__Echo( "first" );

			iCountWait = iCountWait - 1;
			aaWaits[iID] = { "JSON": eJSON_Response, "Event": eProgressEvent, "XHR": eXHR, "Success": bFlag_Success };

			if ( iCountWait == 0 )
			{
				fCallback( arRequests, aaWaits );
			}
		}
	}
}


// -------------------------------------------------------------------
// build request

function SIMPL__BuildRequest_JSON()
{
	var eJSON = 
		{ 
			"API" : 
				{ 
					"Name" : SIMPL__STRING__JSON__API_NAME__DEFAULT, 
					"Version" : SIMPL__STRING__JSON__API_VERSION
				}, 
			"Request" : 
				{ 
					"Command" : ""
				} 
		};

	return eJSON;
}



// -------------------------------------------------------------------
// synchronous request



// ===================================================================
// debug
// -------------------------------------------------------------------

function SIMPL__JSON__AddDebugView( eString_ElementID )
{
	if ( SIMPL__BOOLEAN__DEBUG )
	{
		if ( eString_ElementID == null )
		{
			eString_ElementID = SIMPL__STRING__ELEMENT_ID__DEBUG__DEBUG_VIEW__DIV;
		}

		var eElement_Base = document.getElementById( eString_ElementID );
		if ( eElement_Base != null )
		{
			var eElement;

			eElement = document.createElement( "div" );
			eElement.id = STRING__SIMPL__ELEMENT_ID__DEBUG_VIEW__JSON__REQUEST;
			if ( SIMPL__BOOLEAN__DEBUG__DEBUG_VIEW__SHOW_STATE )
			{
				eElement.setAttribute( "style", "display: block" );
			}
			else
			{
				eElement.setAttribute( "style", "display: none" );
			}

			eElement_Base.appendChild( eElement );

			eElement = document.createElement( "div" );
			eElement.id = STRING__SIMPL__ELEMENT_ID__DEBUG_VIEW__JSON__RESPONSE;
			if ( SIMPL__BOOLEAN__DEBUG__DEBUG_VIEW__SHOW_STATE )
			{
				eElement.setAttribute( "style", "display: block" );
			}
			else
			{
				eElement.setAttribute( "style", "display: none" );
			}

			eElement_Base.appendChild( eElement );
		}
	}
}



// ===================================================================
// local
// -------------------------------------------------------------------

// -------------------------------------------------------------------
// debug

function local_SIMPL__JSON__UpdateDebugView( eString_Request, eString_Response )
{
	var eElement;

	eElement = document.getElementById( STRING__SIMPL__ELEMENT_ID__DEBUG_VIEW__JSON__REQUEST );
	if ( eElement != null )
	{
		eElement.innerHTML = eString_Request;
	}
	else
	{
		console.log( "Request : " );
		console.log( eString_Request );
	}

	eElement = document.getElementById( STRING__SIMPL__ELEMENT_ID__DEBUG_VIEW__JSON__RESPONSE );
	if ( eElement != null )
	{
		eElement.innerHTML = eString_Response;
	}
	else
	{
		console.log( "Response : " );
		console.log( eString_Response );
	}
}



