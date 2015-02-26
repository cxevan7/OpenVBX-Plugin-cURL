# OpenVBX-Plugin-cURL
This is a plugin to allow the OpenVBX platform to make curl calls to the server, receive a json response back, and parse it before providing a response back to the caller.

# How to Use
When creating a call flow, you can drop the cURL applet into the call, it will then ask you to provide something that is said to the caller. Once that file is said/read to the caller, you can provide a max number of digits to gather, and the URL to cURL where you will have the Digits passed.

After that you will choose what happens after the response has been parsed and sent back to the caller.

# JSON Format
When the cURL is processing the request, it expects the response to be in JSON format, the JSON should look like this:

```
{"status":"success","msg":"This is going to be the data of whatever the type call is.","type":"Say"}
```

The type can be any of the following:

Play, 
Sms, 
Dial, 
Hangup, 
Say

if the status is not success, it can be one of the following:

Play, 
Hangup, 
Say

if the status is not success it will do its parsing, Say/Play what it needs to, and it will make the gather call again.

If for any reason the JSON does not come through as JSON the caller will be given an error "You have entered an invalid selection" and the gather call is repeated.

