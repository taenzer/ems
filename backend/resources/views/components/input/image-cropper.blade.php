@props(['name', 'label'])

<x-script.cropper></x-script.cropper>



<div x-data="imageCropAndUpload('', 0.5)">
    <x-input name="{{ $name }}" label="{{ $label }}" type="file" accept="image/*" @change="fileChosen" />
    <div><img x-data x-init="preview = $el"  :src="imageUrl"></div>
    
    <template x-if="!imageUrl">
        <p>KEIN</p>
    </template>
    

</div>


<script>
    function imageCropAndUpload(src = '', aspect = 1) {
        return {
            imageUrl: src,
            aspectRatio: aspect,
            cropper: null,
            preview: null,
            fileChosen(event) {
                this.fileToDataUrl(event, src => this.imageUrl = src)
            },
            fileToDataUrl(event, callback) {
                if (! event.target.files.length) return

                let file = event.target.files[0],
                reader = new FileReader()

                reader.readAsDataURL(file)
                reader.onload = (e) => {
                    callback(e.target.result);
                    if(!this.cropper){
                        cropper = new Cropper( this.preview, {
                            aspectRatio: this.aspectRatio, // Verhältnis, in dem das Bild zugeschnitten wird
                            viewMode: 2,   // Zeigt das Bild im Zuschneide-Modus an
                        }); 
                    }
                    cropper.replace(e.target.result) 
                }
            },
            dataURLtoFile(dataurl, filename) {
                var arr = dataurl.split(','),
                    mime = arr[0].match(/:(.*?);/)[1],
                    bstr = atob(arr[arr.length - 1]), 
                    n = bstr.length, 
                    u8arr = new Uint8Array(n);
                while(n--){
                    u8arr[n] = bstr.charCodeAt(n);
                }
                return new File([u8arr], filename, {type:mime});
            }
        }
    }
</script>

{{-- 

<script>

    function initCropper(event){
        const cropper = new Cropper(event.target, {
            aspectRatio: 1, // Verhältnis, in dem das Bild zugeschnitten wird
            viewMode: 2, // Zeigt das Bild im Zuschneide-Modus an
        });
    }
    

    function imageChange() {
        const file = this.files[0];
        const reader = new FileReader();

        reader.onload = (e) => {
            imagePreview.src = e.target.result;
            cropper.replace(e.target.result);
        };

        reader.readAsDataURL(file);
    }

    cropButton.addEventListener('click', function() {
        const croppedData = cropper.getCroppedCanvas().toDataURL();
        // Hier kannst du das zugeschnittene Bild temporär speichern und auf den Server hochladen
    });
</script>
<div x-data="{}">
    <img id="imagePreview" @load="initCropper(this)" src="" alt="Preview">
    <button id="cropButton">Zuschneiden</button>
    <x-input @change="imageChange()" id="imageInput" name="{{ $name }}" label="{{ $label }}"
        type="file" />

</div>



 --}}
