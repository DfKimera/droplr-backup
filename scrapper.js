// WARNING: don't forget to scroll your window all the way to the bottom! Else you won't get all the drops in the account

// Droplr replaces the native console with empty functions, this should restore it on Chrome
delete window.console;

var idList = [];
var numDrops = 0;
console.log("Collecting drop IDs...");

for(var i in Droplr.DropList.models) {

	// Find the drop ID in the list
	var dropID = Droplr.DropList.models[i].id;

	if(idList.indexOf(dropID) == -1) { // If ID is not on the list, add it to the list
		idList.push('"'+dropID+'"');
		numDrops++;
	}
}

// Return the data
console.log(numDrops + " drops collected; copy the line below and paste it on downloader.php's first line");
console.info("$dropIDs = array(" + idList.join(", ") + ");");