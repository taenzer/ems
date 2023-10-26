@props(['name', 'label', 'aspect_ratio' => 1, 'src' => ''])

<x-script.cropper></x-script.cropper>



<div x-data="imageCropAndUpload(@js($src), @js($aspect_ratio))" {{ $attributes }} >
    <x-input name="{{ $name }}" label="{{ $label }}" type="file" accept="image/*" @change.prevent="fileChosen" hint="Bitte keine zu großen Bilder auswählen, da sie beim Upload noch nicht runterskaliert werden (können)."/>
   
    <div class="preview-cropped" style="aspect-ratio: {{ $aspect_ratio }}; width: 100%;">
        <x-spinner x-show="loading"></x-spinner>
        <img :src="preview" x-show="imageUrl" class="w-full h-full">
    </div>
    
    
    

    <x-modal name="crop-image"> 
        <div  class="p-4">
            <p class="text-lg font-semibold mb-2">Bildzuschnitt anpassen</p>

            <div class="relative py-2">
                    <div class="absolute w-full h-full bg-slate-50/70 -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2" x-show="loading">
                    <x-spinner  class="absolute -translate-x-1/2 -translate-y-1/2 top-2/4 left-1/2"></x-spinner>
                </div>
                
                <div>
                    <img x-data x-init="image = $el" :src="imageUrl" style="max-width: 100%; display: block; height: auto;">
                </div>
            </div>


            <x-primary-button class="mt-2" x-bind:disabled="loading" @click.prevent="crop">Speichern</x-primary-button>
        </div>
    </x-modal>


</div>



<script>
function imageCropAndUpload(src = '', aspect = 1) {
    return {
        imageUrl: src,
        preview: "",
        aspectRatio: aspect,
        file: null,
        filename: "",
        cropper: null,
        image: null,
        loading: false,
        crop(closeModal = true) {
            this.preview = this.cropper.getCroppedCanvas().toDataURL();
            this.$dispatch("update", this.preview);
            if (closeModal) {
                this.$dispatch('close', 'crop-image');
            }
        },
        fileChosen(event) {
            this.loading = true;
            this.$dispatch('open-modal', 'crop-image');
            this.fileToDataUrl(event, src => this.imageUrl = src);
        },
        fileToDataUrl(event, callback) {
            if (!event.target.files.length) return

            if (this.cropper) {
                this.cropper.destroy();
            }

            let file = event.target.files[0],
                reader = new FileReader();

            this.filename = file.name;

            reader.readAsDataURL(file)
            reader.onload = (e) => {
                callback(e.target.result);
                if (!this.cropper) {
                    this.cropper = this.createCropper();
                }
                this.cropper.replace(e.target.result)
            }
        },
        dataURLtoFile(dataurl, filename) {
            var arr = dataurl.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[arr.length - 1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);
            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, {
                type: mime
            });
        },
        createCropper() {
            return new Cropper(this.image, {
                aspectRatio: this.aspectRatio, // Verhältnis, in dem das Bild zugeschnitten wird
                viewMode: 0, // Zeigt das Bild im Zuschneide-Modus an
                autoCropArea: 1,
                dragMode: 'move',
                cropBoxMovable: false,
                cropBoxResizable: false,
                center: false,
                guides: false,
                highlight: false,
                restore: false,
                toggleDragModeOnDblclick: false,
                autocrop: true,

                ready: (data = this) => {
                    this.preview = this.cropper.getCroppedCanvas().toDataURL();
                    this.$dispatch("update", this.preview);
                    this.loading = false;
                }
            });
        }
    }
}
</script>