// Stores the reference to the XMLHttpRequest object
var xmlHttp = createXmlHttpRequestObject(); 

// Retrieves the XMLHttpRequest object
function createXmlHttpRequestObject() 
{	
    // Stores the reference to the XMLHttpRequest object
    var xmlHttp;
    // If running Internet Explorer 6 or older
    if(window.ActiveXObject)
    {
        try
        {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch (e)
        {
            xmlHttp = false;
        }
    }
    // If running Mozilla or other browsers
    else
    {
        try
        {
            xmlHttp = new XMLHttpRequest();
        }
        catch (e)
        {
            xmlHttp = false;
        }
    }
    // Returns the created object or displays an error message
    if(!xmlHttp)
        alert("Error creating the XMLHttpRequest object.");
    else 
        return xmlHttp;
}

// Makes an asynchronous HTTP request using the XMLHttpRequest object 
function process()
{
    // Proceeds only if the xmlHttp object isn't busy
    if(xmlHttp.readyState == 4 || xmlHttp.readyState == 0)
    {
        // Retrieves the movie title typed by the user on the form
        title = encodeURIComponent(document.getElementById("title").value);
        // Executes the 'xss_ajax_1-2.php' page from the server
        xmlHttp.open("GET", "xss_ajax_1-2.php?title=" + title, true);  
        // Defines the method to handle server responses
        xmlHttp.onreadystatechange = handleServerResponse;
        // Makes the server request
        xmlHttp.send(null);
    }
    else
        // If the connection is busy, try again after one second  
        setTimeout("process()", 1000);
}

// Callback function executed when a message is received from the server
function handleServerResponse() 
{
    // Move forward only if the transaction has completed
    if(xmlHttp.readyState == 4) 
    {
        // Status of 200 indicates the transaction completed successfully
        if(xmlHttp.status == 200) 
        {
            // Extracts the XML retrieved from the server
            xmlResponse = xmlHttp.responseXML;
            // Obtains the document element (the root element) of the XML structure
            xmlDocumentElement = xmlResponse.documentElement;
            // Gets the text message, which is in the first child of the document element
            result = xmlDocumentElement.firstChild.data;
            // Displays the data received from the server
            document.getElementById("result").innerHTML = result;
            // Restart sequence
            setTimeout("process()", 1000);
        } 
        // A HTTP status different than 200 signals an error
        else 
        {
            alert("There was a problem accessing the server: " + xmlHttp.statusText);
        }
    }
}