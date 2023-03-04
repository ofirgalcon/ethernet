#!/bin/bash

# ethernet controller
CTL="${BASEURL}index.php?/module/ethernet/"

# Get the scripts in the proper directories
"${CURL[@]}" "${CTL}get_script/ethernet" -o "${MUNKIPATH}preflight.d/ethernet"

# Check exit status of curl
if [ $? = 0 ]; then
	# Make executable
	chmod a+x "${MUNKIPATH}preflight.d/ethernet"

	# Set preference to include this file in the preflight check
	setreportpref "ethernet" "${CACHEPATH}ethernet.plist"

else
	echo "Failed to download all required components!"
	rm -f "${MUNKIPATH}preflight.d/ethernet"

	# Signal that we had an error
	ERR=1
fi
