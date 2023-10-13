@push('head-scripts')
<script src="https://unpkg.com/@api.video/video-uploader" defer></script>
@endpush

<form action="" wire:submit.prevent="submit">
    <div class="grid grid-cols-2 gap-6">
        <div>
            {{ $this->form }}
        </div>
        <div>
            <div x-data="{ 
                    progress: 0,
                    uploading: false,
                    videoThumbnail: @entangle('video_thumbnail'),
                    videoUrl: @entangle('video_url'),
                    imgPreview: false,
                    done: false,
                    uploadFile(video){
                        console.log(video);
                        const uploader = new VideoUploader({
                            file: video,
                            uploadToken: `{{ config('services.apivideo.upload_token') }}`
                        });

                        uploader.onProgress((event) => {
                            this.uploading = true;
                            var percentComplete = Math.round(event.currentChunkUploadedBytes / event.chunksBytes * 100);
                            this.progress = Math.round(event.uploadedBytes / event.totalBytes * 100);
                        });

                        uploader.upload()
                            .then((video) => {
                                @this.saveApiVideo(video);
                                this.videoThumbnail = video['assets']['thumbnail'];
                                this.done = true;
                                this.videoUrl = video['assets']['player'];
                                this.uploading = false;
                            });
                    }
                }"
                class="p-6 bg-gray-200 rounded-lg">
                
                
                <div x-show="imgPreview" class="mb-3 rounded-md bg-gray-500/10">
                    <a :href="videoUrl" target="_blank">
                        <img :src="videoThumbnail" 
                        x-on:error="
                        if(videoThumbnail){
                            setTimeout(() => { 
                                videoThumbnail = videoThumbnail + '?_t=' + Date.now() 
                            }, 1000)
                        }   
                        "
                        x-on:load="imgPreview = true" 
                        class="w-64 h-32 mx-auto">
                    </a>
                </div>
                <div x-show="!imgPreview && done" class="mb-3">
                    <div class="flex items-center justify-center w-64 h-32 mx-auto bg-gray-300 rounded-md">
                        <div role="status">
                            <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-emerald-700" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <label for="video" class="relative block p-4 bg-gray-100 rounded-lg cursor-pointer">
                    <div class="px-1 py-3 rounded-md bg-gray-500/10">
                        <div class="flex items-center justify-center">
                            <x-heroicon-o-upload class="mr-4 w-7 h-7"/>
                            <h3 class="font-bold">Upload Video File</h3>
                        </div>
                        <input type="file" id="video" accept="video/mp4,video/x-m4v,video/*" class="hidden" x-on:change="uploadFile($event.target.files[0])">
                        <p class="mt-2 text-sm text-center">Video types acceptable: .mp4, .mov, .mpeg</p>
                    </div>
                </label>

                
                <section x-show="uploading" x-cloak class="mt-2">
                    <div class="flex justify-between mb-1">
                        <span class="text-xs font-medium text-primary dark:text-white">Uploading</span>
                        <span class="text-xs font-medium text-primary dark:text-white"><span x-text="progress"></span>%</span>
                    </div>
                    <div class="w-full bg-gray-300 rounded-full h-1.5 dark:bg-gray-700">
                        <div class="h-1.5 rounded-full bg-darkgreen" x-bind:style="'width: ' + progress + '%'"></div>
                    </div>
                </section>
  
                
                <div class="py-6 text-center">
                    <p>or</p>
                </div>
                <div class="relative p-4 rounded-lg bg-gray-200">
                    {{-- <div class="absolute inset-0 rounded-lg cursor-not-allowed bg-gray-900/50"></div> --}}
                    <div class="flex items-center justify-center">
                        <x-heroicon-s-play class="mr-4 w-7 h-7"/>
                        <h3 class="font-bold">Paste Video Source URL</h3>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <input wire:model.defer="video_url" name="videourl" type="url" class="w-full border border-gray-300 rounded-md" placeholder="Copy and paste your video link">
                        <button type="button" class="btn-primary" wire:click="saveURLVideo">Insert</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between pt-4 mt-8 border-t">
        <p class="text-xl font-bold text-primary">Add Video</p>
        <div class="flex gap-2">
            <button x-data x-on:click="$dispatch('closemodal-video')" type="button" class="btn-default">Cancel</button>
            @if($action == \App\Enums\ActionType::Update)
                @if(!$new_upload || $ready_for_upload)
                <button type="submit" class="btn-warning">Update</button>
                @else
                <button type="button" disabled class="btn-warning btn-disabled">Update</button>
                @endif
            @else
                @if($ready_for_upload)
                <button type="submit" class="btn-primary">Save</button>
                @else
                <button type="button" disabled class="btn-primary btn-disabled">Save</button>
                @endif
            @endif
        </div>
    </div>
</form>