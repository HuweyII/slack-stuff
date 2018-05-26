#!/usr/bin/python3

import sys
import json
import urllib.request
import urllib.parse

# This file should contain a single variable called slackkey that includes the URL with key, like this
# slackkey = "https://hooks.slack.com/services/xxxxx/xxxxxx/xxxxxxxx"
# get your webhook here -- https://my.slack.com/services/new/incoming-webhook/
PASSWORDFILE = ".slackkeypy3"

# Import password file
with open(PASSWORDFILE) as f:
    code = compile(f.read(), "somefile.py", 'exec')
    exec(code)

# Read command line arguments
try:
	botname = sys.argv[1]
	emoji = ":" + sys.argv[2] + ":"
	channel = sys.argv[3]
	msg = sys.argv[4].replace("&", "and")
except:
	print("Not enough command line arguments")
	print("Usement: " + sys.argv[0] + " \"botname\" \"emoji\" \"channel\" \"message\"")

# Format JSON data to send
data = json.dumps({"channel":channel,"username":channel,"text":msg,"icon_emoji":emoji})

# Send the data to the Slack API
params = data.encode('utf8')
req = urllib.request.Request(slackkey, data=params,
	headers={'content-type': 'application/json'})
response = urllib.request.urlopen(req)

