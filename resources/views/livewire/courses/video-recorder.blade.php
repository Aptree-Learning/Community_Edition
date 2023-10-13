<div x-data="{
    isDraw: true,
}" x-on:openmodal-record.window="setAudioInputSelect();">
    <div class="{{ $step == 'record' ? '' : 'hidden' }} flex flex-wrap-reverse">
        <div class="mx-auto w-full rounded-md border border-gray-200 px-4 py-8 shadow xl:w-fit xl:min-w-[420px]">
            <p class="text-md font-bold text-black">Select Source</p>
            <select id="sources" name="tabs" onchange="handleChangeSource(event.target.value)"
                class="my-2 mb-4 block w-full rounded-md border-gray-200 py-3 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                <option value="">Select a camera source</option>

                <option value="camera">Web Camera Only</option>

                <option value="screen">Screen Only</option>

                <option value="screen-camera">Web Camera & Screen</option>
            </select>

            <select id="audios" name="tabs" onchange="handleChangeAudioSource(event.target.value)"
                class="my-2 mb-4 block w-full rounded-md border-gray-200 py-3 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                <option value="">Select an audio source</option>
            </select>

            <p class="text-md py-2 font-bold text-black">Tool</p>
            <div class="my-2 mb-4 flex rounded-md border border-gray-200">
                <div onclick="handleChangeTool('move-resize')" id="move-resize" @click="isDraw = false"
                    class="gorder-gray-200 flex flex-1 cursor-pointer items-center border-r p-4 hover:bg-[#F3F6FF] hover:text-blue-500">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" class="mr-2"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4.66675 11.3337V0.666992H3.33341V3.33366H0.666748V4.66699H3.33341V11.3337C3.33341 11.6873 3.47389 12.0264 3.72394 12.2765C3.97399 12.5265 4.31313 12.667 4.66675 12.667H11.3334V15.3337H12.6667V12.667H15.3334V11.3337M11.3334 10.0003H12.6667V4.66699C12.6667 3.92699 12.0667 3.33366 11.3334 3.33366H6.00008V4.66699H11.3334V10.0003Z"
                            fill="#2F5662" />
                    </svg>
                    Move / Resize
                </div>
                <div onclick="handleChangeTool('draw')" id="draw" @click="isDraw = true"
                    class="gorder-gray-200 flex flex-1 cursor-pointer items-center border-r p-4 hover:bg-[#F3F6FF] hover:text-blue-500">
                    <svg width="14" height="12" viewBox="0 0 14 12" fill="none" class="mr-2"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.50001 11.9003C6.68668 11.4336 6.42668 10.147 5.82668 9.33362C5.23334 8.50029 4.41334 7.92695 3.58668 7.37362C3.00001 7.00029 2.46001 6.53362 2.02668 6.00029C1.84001 5.78029 1.46001 5.37362 1.84668 5.29362C2.24001 5.21362 2.92001 5.60029 3.26668 5.74695C3.87334 6.00029 4.47334 6.29362 5.03334 6.64029L5.70668 5.50695C4.66668 4.82029 3.33334 4.21362 2.09334 4.03362C1.38668 3.92695 0.640011 4.07362 0.400011 4.84029C0.186677 5.50029 0.526677 6.16695 0.913344 6.68695C1.82668 7.90695 3.24668 8.49362 4.30668 9.54695C4.53334 9.76695 4.80668 10.027 4.94001 10.3336C5.08001 10.627 5.04668 10.647 4.73334 10.647C3.90668 10.647 2.87334 10.0003 2.20001 9.57362L1.52668 10.707C2.54668 11.3336 4.25334 12.3136 5.50001 11.9003ZM12.8933 1.50029C13.04 1.35362 13.04 1.11362 12.8933 0.97362L12.0267 0.106953C11.8867 -0.0330469 11.6467 -0.0330469 11.5067 0.106953L10.8267 0.786953L12.2133 2.17362M6.33334 5.28029V6.66695H7.72001L11.82 2.56695L10.4333 1.18029L6.33334 5.28029Z"
                            fill="#2F5662" />
                    </svg>
                    Draw
                </div>
            </div>
            <div x-show="isDraw">
                <p class="py-2 text-sm text-black">Line Color</p>
                <div class="mb-4 flex">
                    <div class="mr-3 h-6 w-6 cursor-pointer rounded-full border border-red-500 bg-white transition-all hover:scale-[1.1]"
                        onclick="setColor('#FFFFFF')" id="#FFFFFF"></div>
                    <div class="mr-3 h-6 w-6 cursor-pointer rounded-full bg-[#FFB020] transition-all hover:scale-[1.1]"
                        onclick="setColor('#FFB020')" id="#FFB020"></div>
                    <div class="mr-3 h-6 w-6 cursor-pointer rounded-full bg-[#897AE3] transition-all hover:scale-[1.1]"
                        onclick="setColor('#897AE3')" id="#897AE3"></div>
                    <div class="mr-3 h-6 w-6 cursor-pointer rounded-full bg-[#6BDAAE] transition-all hover:scale-[1.1]"
                        onclick="setColor('#6BDAAE')" id="#6BDAAE"></div>
                    <div class="mr-3 h-6 w-6 cursor-pointer rounded-full bg-[#70B0FF] transition-all hover:scale-[1.1]"
                        onclick="setColor('#70B0FF')" id="#70B0FF"></div>
                    <div class="mr-3 h-6 w-6 cursor-pointer rounded-full bg-[#3366FF] transition-all hover:scale-[1.1]"
                        onclick="setColor('#3366FF')" id="#3366FF"></div>
                </div>
                <p class="py-2 text-sm text-black">Auto-erase Delay</p>
                <select id="tabs" name="tabs" onchange="setDelay(event.target.value)"
                    class="my-2 mb-4 block w-full rounded-md border-gray-200 py-3 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    <option value="0">Disabled</option>
                    <option value="3">Every 3 seconds</option>
                    <option value="5" selected>Every 5 seconds</option>
                    <option value="10">Every 10 seconds</option>
                </select>
            </div>
            <button class="btn-primary my-5 flex w-full items-center justify-center !py-3" id="start">
                <svg width="20" height="20" viewBox="0 0 14 14" fill="none" class="mr-3"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M6.99992 12.333C5.58543 12.333 4.22888 11.7711 3.22868 10.7709C2.22849 9.77072 1.66659 8.41416 1.66659 6.99967C1.66659 5.58519 2.22849 4.22863 3.22868 3.22844C4.22888 2.22824 5.58543 1.66634 6.99992 1.66634C8.41441 1.66634 9.77096 2.22824 10.7712 3.22844C11.7713 4.22863 12.3333 5.58519 12.3333 6.99967C12.3333 8.41416 11.7713 9.77072 10.7712 10.7709C9.77096 11.7711 8.41441 12.333 6.99992 12.333ZM6.99992 0.333008C6.12444 0.333008 5.25753 0.505446 4.4487 0.840478C3.63986 1.17551 2.90493 1.66657 2.28587 2.28563C1.03563 3.53587 0.333252 5.23156 0.333252 6.99967C0.333252 8.76778 1.03563 10.4635 2.28587 11.7137C2.90493 12.3328 3.63986 12.8238 4.4487 13.1589C5.25753 13.4939 6.12444 13.6663 6.99992 13.6663C8.76803 13.6663 10.4637 12.964 11.714 11.7137C12.9642 10.4635 13.6666 8.76778 13.6666 6.99967C13.6666 6.1242 13.4941 5.25729 13.1591 4.44845C12.8241 3.63961 12.333 2.90469 11.714 2.28563C11.0949 1.66657 10.36 1.17551 9.55114 0.840478C8.7423 0.505446 7.8754 0.333008 6.99992 0.333008ZM6.99992 3.66634C6.11586 3.66634 5.26802 4.01753 4.6429 4.64265C4.01777 5.26777 3.66659 6.11562 3.66658 6.99967C3.66659 7.88373 4.01777 8.73158 4.6429 9.3567C5.26802 9.98182 6.11586 10.333 6.99992 10.333C7.88397 10.333 8.73182 9.98182 9.35694 9.3567C9.98206 8.73158 10.3333 7.88373 10.3333 6.99967C10.3333 6.11562 9.98206 5.26777 9.35694 4.64265C8.73182 4.01753 7.88397 3.66634 6.99992 3.66634Z"
                        fill="white" />
                </svg>

                Start Recording
            </button>
            <button class="btn-primary my-5 flex hidden w-full items-center justify-center !bg-red-500 !py-3"
                id="stop">
                <svg aria-hidden="true" class="mr-2 hidden h-5 w-5 animate-spin fill-blue-600 text-white"
                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg" id="loading">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor" />
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill" />
                </svg>
                <svg width="25" height="25" fill="white" class="mr-2" focusable="false" aria-hidden="true"
                    viewBox="0 0 24 24" data-testid="StopCircleIcon" id="stop_icon">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4 14H8V8h8v8z">
                    </path>
                </svg>

                Stop Recording
            </button>
        </div>
        <div class="flex-1 px-4 py-8">
            <div id="canvas-container" class="m-auto"> </div>
        </div>
    </div>

    <form action="" wire:submit.prevent="submit">
        <div class="{{ $step == 'submit' ? '' : 'hidden' }} flex flex-wrap-reverse">
            <div class="mx-auto w-full rounded-md border border-gray-200 px-4 py-8 shadow xl:w-fit xl:min-w-[420px]">
                {{ $this->form }}
            </div>
            <div class="flex flex-1 items-start justify-center px-4 py-8" id="my_video">
                @if ($this->video)
                    <iframe src="{{ $this->video['assets']['player'] }}" frameborder="0" allowfullscreen
                        class="h-full w-full rounded-md shadow"></iframe>
                @endif
            </div>
        </div>

        <div class="mt-8 flex items-center justify-between border-t pt-4">
            <p class="text-primary text-xl font-bold">Record Video</p>
            <div class="flex gap-2">
                <button x-data x-on:click="$dispatch('closemodal-record')" type="button"
                    class="btn-default mr-2 rounded-md border border-gray-300 px-4">Cancel</button>
                <button type="submit" class="btn-primary" id="save_button"
                    {{ $this->video ? '' : 'disabled' }}>Save</button>
            </div>
        </div>
    </form>
    <script>
        let currentColor = "#FFFFFF";
        let currentDelay = 5;
        let screenStream;
        let cameraStream;
        let audioStream;
        let audioSourceId;
        let audioDevices = [];
        let audioDeviceGroups = {};
        const canvasContainer = document.getElementById('canvas-container');
        const startButton = document.getElementById("start");
        const stopButton = document.getElementById("stop");
        const loadingIcon = document.getElementById("loading");
        const stopIcon = document.getElementById("stop_icon");
        const videoLink = document.getElementById("video-link");
        const audioSelect = document.getElementById("audios");
        const width = "520";
        const height = "320";
        let mediaStreamComposer = new MediaStreamComposer({
            resolution: {
                width,
                height
            }
        });
        const setAudioInputSelect = async () => {
            await navigator.mediaDevices.getUserMedia({
                audio: true,
                video: true
            });
            audioDevices = await navigator.mediaDevices.enumerateDevices();
            console.log(audioDevices);
            for (let i = 0; i < audioDevices.length; i++) {
                if (audioDevices[i].kind === 'audioinput') {
                    const option = document.createElement("option");
                    let labelName = audioDevices[i].label;
                    option.text = labelName.slice(0, 50) + (labelName.length > 50 ? '...' :
                        '');
                    option.value = audioDevices[i].groupId;
                    audioSelect.add(option);
                    if (audioDevices[i].deviceId != 'default' || audioDevices[i].deviceId != 'communications') {
                        audioDeviceGroups[audioDevices[i].groupId] = audioDevices[i].deviceId;
                    }
                }
            }
        }

        mediaStreamComposer.appendCanvasTo("#canvas-container");

        mediaStreamComposer.setDrawingSettings({
            color: currentColor,
            lineWidth: 5,
            autoEraseDelay: currentDelay,
        });

        canvasContainer.style.width = `${width}px`;
        canvasContainer.style.height = `${height}px`;
        canvasContainer.style.background = `black`;

        const setColor = (value) => {
            document.getElementById(currentColor).classList.remove("border", "border-red-500");
            currentColor = value;
            mediaStreamComposer.setDrawingSettings({
                color: currentColor,
                lineWidth: 5,
                autoEraseDelay: currentDelay,
            });
            document.getElementById(currentColor).classList.add("border", "border-red-500");
        }

        const setDelay = (value) => {
            currentDelay = parseInt(value);
            mediaStreamComposer.setDrawingSettings({
                color: currentColor,
                lineWidth: 5,
                autoEraseDelay: currentDelay,
            });
        }

        async function handleChangeSource(source) {
            if (screenStream) {
                mediaStreamComposer.removeStream(screenStream);
                screenStream = null;
            }
            if (cameraStream) {
                mediaStreamComposer.removeStream(cameraStream);
                cameraStream = null;
            }
            if (source.indexOf('screen') >= 0 && !screenStream) {
                if (audioStream) {
                    mediaStreamComposer.removeStream(audioStream);
                }
                if (audioSourceId) {
                    const webcam = await navigator.mediaDevices.getUserMedia({
                        audio: {
                            deviceId: audioSourceId,
                        },
                        video: true,
                    });
                    audioStream = await mediaStreamComposer.addStream(webcam, {
                        position: "fixed",
                        mute: false,
                        y: -30,
                        left: -30,
                        height: 20,
                    });
                }
                screencast = await navigator.mediaDevices.getDisplayMedia();
                screenStream = await mediaStreamComposer.addStream(screencast, {
                    position: "contain",
                    mute: true,
                });
            }
            if (source.indexOf('camera') >= 0 && !cameraStream) {
                console.log(audioSourceId);
                if (audioStream) {
                    mediaStreamComposer.removeStream(audioStream);
                }
                const webcam = await navigator.mediaDevices.getUserMedia({
                    audio: audioSourceId ? {
                        deviceId: audioSourceId,
                    } : false,
                    video: true
                });
                cameraStream = await mediaStreamComposer.addStream(webcam, {
                    position: "fixed",
                    mute: false,
                    y: source == 'camera' ? 0 : (height - 90),
                    left: 0,
                    height: source == 'camera' ? 320 : 90,
                    width: source == 'camera' ? 520 : 90,
                    mask: source == 'camera' ? "rectangle" : "circle",
                    draggable: source == 'camera' ? false : true,
                    resizable: source == 'camera' ? false : true,
                });
            }
        }

        startButton.onclick = () => {
            mediaStreamComposer.startRecording({
                uploadToken: "{{ config('services.apivideo.upload_token') }}",
            });
            startButton.classList.toggle('hidden');
            stopButton.classList.toggle('hidden');
        }

        // when the stop button is clicked, stop the recording and display the video link
        stopButton.onclick = () => {
            mediaStreamComposer.stopRecording().then(a => {
                // videoLink.innerHTML = a.assets.player;
                console.log(a);
                if (a.assets.player) {
                    @this.changeVideo(a);
                }
                startButton.classList.toggle('hidden');
                stopButton.classList.toggle('hidden');
            });
            stopIcon.classList.toggle('hidden');
            loadingIcon.classList.toggle('hidden');
            stopButton.disabled = true;
        }

        function handleChangeTool(tool) {
            mediaStreamComposer.setMouseTool(tool);
            document.getElementById(tool).classList.add("bg-[#F3F6FF]", "text-blue-500");
            document.getElementById(tool === 'draw' ? 'move-resize' : 'draw').classList.remove("bg-[#F3F6FF]",
                "text-blue-500");
        }

        async function handleChangeAudioSource(value) {
            console.log(value);
            audioSourceId = audioDeviceGroups[value];
            if (cameraStream) {
                mediaStreamComposer.removeStream(cameraStream);
                console.log(audioSourceId);
                const webcam = await navigator.mediaDevices.getUserMedia({
                    audio: audioSourceId ? {
                        deviceId: audioSourceId,
                    } : false,
                    video: true,
                });
                cameraStream = await mediaStreamComposer.addStream(webcam, {
                    position: "fixed",
                    mute: false,
                    y: height - 90,
                    left: 0,
                    height: 90,
                    mask: "circle",
                    draggable: true,
                    resizable: true,
                });
            } else {
                if (audioStream) {
                    mediaStreamComposer.removeStream(audioStream);
                }
                console.log(audioSourceId);
                if (audioSourceId) {
                    const webcam = await navigator.mediaDevices.getUserMedia({
                        audio: {
                            deviceId: audioSourceId,
                        },
                        video: true,
                    });
                    audioStream = await mediaStreamComposer.addStream(webcam, {
                        position: "fixed",
                        mute: false,
                        y: -30,
                        left: -30,
                        height: 20,
                    });
                }
            }
        }
        handleChangeTool('draw');
    </script>
</div>
