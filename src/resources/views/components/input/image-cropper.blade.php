@props(['name', 'label', 'aspect_ratio' => 1, 'src' => ''])

<x-script.cropper></x-script.cropper>


<div x-data="imageCropAndUpload(@js($src), @js($aspect_ratio))" {{ $attributes }}>
    <p class="mb-2 block text-xs font-bold uppercase text-gray-700">
        {{ $label }}
    </p>

    <x-input name="{{ $name }}" type="file" accept="image/*" @change.prevent="fileChosen" :hidden="!empty($src)"
        hint="Bitte keine zu großen Bilder auswählen, da sie beim Upload noch nicht runterskaliert werden (können)."
        x-ref="fileinput" />



    <div class="preview-cropped relative" style="aspect-ratio: {{ $aspect_ratio }}; width: 100%;">
        @if (!empty($src))
            <span class="absolute right-2 top-2 cursor-pointer rounded-full bg-white p-2 shadow-lg" @click="$refs.fileinput.click()">
                <x-misc.icon name="edit"></x-misc.icon></span>
        @endif
        <x-spinner x-show="loading"></x-spinner>
        <img :src="preview" x-show="imageUrl" class="h-full w-full">
    </div>




    <x-modal name="crop-image">
        <div class="max-h-screen p-4">
            <p class="mb-2 text-lg font-semibold">Bildzuschnitt anpassen</p>

            <div class="relative py-2">
                <div class="absolute left-1/2 top-2/4 h-full w-full -translate-x-1/2 -translate-y-1/2 bg-slate-50/70"
                    x-show="loading">
                    <x-spinner class="absolute left-1/2 top-2/4 -translate-x-1/2 -translate-y-1/2"></x-spinner>
                </div>

                <div>
                    <img x-data x-init="image = $el" :src="imageUrl"
                        style="max-width: 100%; display: block; height: auto;">
                </div>
            </div>


            <x-primary-button class="mt-2" x-bind:disabled="loading"
                @click.prevent="crop">Speichern</x-primary-button>
        </div>
    </x-modal>


</div>



<script>
    function imageCropAndUpload(src = '', aspect = 1) {
        return {
            imageUrl: src,
            preview: src,
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
