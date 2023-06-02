//webkitURL is deprecated but nevertheless
URL = window.URL || window.webkitURL;

var gumStream; 						//stream from getUserMedia()
var recorder; 						//WebAudioRecorder object
var input; 							//MediaStreamAudioSourceNode  we'll be recording
var encodingType; 					//holds selected encoding for resulting audio (file)
var encodeAfterRecord = true;       // when to encode
var process_id;
// shim for AudioContext when it's not avb. 
var AudioContext = window.AudioContext || window.webkitAudioContext;
var audioContext; //new audio context to help us record

var encodingTypeSelect = "wav"; // wav, mp3, ogg
var recordButton = document.getElementById("recordButton");
var stopButton = document.getElementById("stopButton");
var recordProgress = document.getElementById("recordProgress");
var recordProgressBar = document.getElementById("recordProgressBar");

//add events to those 2 buttons
recordButton.addEventListener("click", startRecording);
stopButton.addEventListener("click", stopRecording);

function startRecording() {
	// console.log("startRecording() called");

	/*
		Simple constraints object, for more advanced features see
		https://addpipe.com/blog/audio-constraints-getusermedia/
	*/
    
    var constraints = { audio: true, video:false }

    /*
    	We're using the standard promise based getUserMedia() 
    	https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia
	*/

	navigator.mediaDevices.getUserMedia(constraints).then(function(stream) {
		/*
			create an audio context after getUserMedia is called
			sampleRate might change after getUserMedia is called, like it does on macOS when recording through AirPods
			the sampleRate defaults to the one set in your OS for your playback device

		*/
		audioContext = new AudioContext();

		//assign to gumStream for later use
		gumStream = stream;
		
		/* use the stream */
		input = audioContext.createMediaStreamSource(stream);
		
		//get the encoding 
		encodingType = encodingTypeSelect;
		
		recorder = new WebAudioRecorder(input, {
		  workerDir: "new_assets/plugins/recorder/", // must end with slash
		  encoding: encodingType,
		  numChannels:2, //2 is the default, mp3 encoding supports only 2
		  onEncoderLoading: function(recorder, encoding) {
		    // show "loading encoder..." display
		  },
		  onEncoderLoaded: function(recorder, encoding) {
		    // hide "loading encoder..." display
			recordProgress.style.display = "block";
			progressbar();
		  }
		});

		recorder.onComplete = function(recorder, blob) { 
			send_msg(blob,recorder.encoding);
		}

		recorder.setOptions({
		  timeLimit:120,
		  encodeAfterRecord:encodeAfterRecord,
	      ogg: {quality: 0.5},
	      mp3: {bitRate: 160}
	    });

		//start the recording process
		recorder.startRecording();
		
	}).catch(function(err) {
	  	//enable the record button if getUSerMedia() fails
    	recordButton.closest(".options").style.display = 'block';
		stopButton.closest(".options").style.display = 'none';

	});

	//disable the record button
    recordButton.closest(".options").style.display = 'none';
    stopButton.closest(".options").style.display = 'block';
}

function progressbar(){
	// console.log(113);
	process_id = setInterval(function(){
		let n = Number(recordProgressBar.dataset.widht) + 1;
		let m = (n*100)/60;
		if(n > 60) {
			// console.log(n);
			clearInterval(process_id); 
			stopRecording(); 
		}
		recordProgressBar.dataset.widht = n;
		recordProgressBar.style.width = m + "%";
		recordProgressBar.innerHTML = n;
	}, 1000);
}

function stopRecording() {
	//stop microphone access
	gumStream.getAudioTracks()[0].stop();

	//disable the stop button
	recordButton.closest(".options").style.display = 'block';
    stopButton.closest(".options").style.display = 'none';
	
	//tell the recorder to finish the recording (stop recording + encode the recorded audio)
	recorder.finishRecording();
	clearInterval(process_id);
}