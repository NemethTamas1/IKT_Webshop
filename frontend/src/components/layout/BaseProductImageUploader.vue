<template>
    <div class="image-upload-container w-3/4 h-3/4">
        <h3 class="text-2xl font-bold mb-4 text-sky-600">
            Termék képének feltöltése
        </h3>

        <!-- Előnézet + feltöltési terület -->
        <div class="flex flex-col items-center gap-4 w-full h-full">
            <!-- Előnézet -->
            <div class="preview-box relative w-full max-w-[500px] lg:max-w-[600px] max-h-[400px] md:max-h-[550px] lg:max-h-[650px] h-full border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition-colors"
                @click="$refs.fileInput.click()" @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop"
                :class="{ 'border-blue-500 bg-blue-50': isDragging }">
                <img v-if="preview" :src="preview" alt="Termék előnézet"
                    class="w-full h-full object-cover rounded-lg" />
                <div v-else class="w-full h-full flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-sky-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <p class="text-gray-600 font-medium">Kép feltöltése</p>
                    <p class="text-gray-400 text-sm mt-1 pb-4 italic">Kattintson vagy húzza ide</p>
                </div>

                <button v-if="preview" @click.stop="$refs.fileInput.click()"
                    class="hover:bg-gray-800 bg-black py-2 px-4 border-2 border-sky-500 rounded-lg text-white font-semibold transition-colors duration-200 absolute bottom-2 right-2 shadow-lg">
                    Módosítás
                </button>
            </div>
            <!-- EZ csak rejtettként van itt, hogy legyen "hová" feltölteni -->
            <input ref="fileInput" type="file" accept="image/jpg,image/jpeg,image/png,image/webp"
                @change="handleFileSelect" class="hidden" />

            <!-- Feltöltött infói -->
            <div v-if="selectedFile" class="text-center text-sm text-gray-600">
                <p class="font-medium">{{ selectedFile.name }}</p>
                <p>{{ fileSize }} MB</p>
            </div>

            <!-- Hibaüzenet -->
            <p v-if="error" class="text-red-500 text-sm text-center">
                {{ error }}
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';

const emit = defineEmits(['image-selected']);

const selectedFile = ref(null);
const preview = ref(null);
const error = ref('');
const isDragging = ref(false);

// Fájlméret 
const fileSize = computed(() => {
    if (!selectedFile.value) return 0;
    return (selectedFile.value.size / (1024 * 1024)).toFixed(2);
});

// Fájl kiválasztás
const handleFileSelect = (event) => {
    const file = event.target.files[0];
    if (file) processFile(file);
};

// Drag & Drop 
const handleDrop = (event) => {
    isDragging.value = false;
    const file = event.dataTransfer.files[0];
    if (file) processFile(file);
};

// Feldolgozása
const processFile = (file) => {
    error.value = '';

    // Méret ellenőrzés (max 5MB)
    if (file.size > 5 * 1024 * 1024) {
        error.value = 'A fájl mérete nem lehet nagyobb 5MB-nál!';
        return;
    }

    selectedFile.value = file;

    // Előnézet létrehozása
    const reader = new FileReader();
    reader.onload = (e) => {
        preview.value = e.target.result;

        // Emit a szülő komponensnek
        emit('image-selected', {
            file: file,
            preview: e.target.result
        });
    };
    reader.readAsDataURL(file);
};

// Kép törlése
const clearImage = () => {
    selectedFile.value = null;
    preview.value = null;
    error.value = '';
    emit('image-selected', null);
};
defineExpose({
    clearImage
});
</script>

<style scoped>
.preview-box {
    transition: all 0.3s ease;
}

.preview-box:hover {
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
}
</style>