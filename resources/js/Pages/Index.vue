<template>
  <div class="w-[500px] fixed left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2">
    <div class="flex items-center justify-center w-full relative">
      <div
          v-if="!file"
          v-bind="getRootProps()"
          class="flex flex-col justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
      >
          <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
              <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"
              />
            </svg>
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400" v-if="isDragActive">Drop the files here ...</p>
            <p v-else class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
          </div>
          <input v-bind="getInputProps()" />
          <button @click="open" id="dropzone-file" type="file" class="hidden" />
      </div>

      <!--File upload info--->
      <div v-else class="flex flex-col justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg" :class="[errors?.file || errors.unique_id ? 'bg-red-300' : ' bg-gray-50 dark:border-gray-600 dark:hover:border-gray-500 dark:bg-gray-700']">
        <div class="px-2">
          <!--Progress bar--->
          <FwbProgress class="w-full" :progress="uploaded" label-position="inside" label-progress size="lg" />
          <!--File info-->
          <div class="flex items-center gap-x-2 justify-self-start mt-1">
                    <span class="w-[60px] h-[60px] bg-[#2385BA33] flex items-center justify-center rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <g clip-path="url(#clip0_3654_183609)">
                                <path
                                    d="M7.5 0C6.50544 0 5.55161 0.395088 4.84835 1.09835C4.14509 1.80161 3.75 2.75544 3.75 3.75V26.25C3.75 27.2446 4.14509 28.1984 4.84835 28.9016C5.55161 29.6049 6.50544 30 7.5 30H22.5C23.4946 30 24.4484 29.6049 25.1516 28.9016C25.8549 28.1984 26.25 27.2446 26.25 26.25V3.75C26.25 2.75544 25.8549 1.80161 25.1516 1.09835C24.4484 0.395088 23.4946 0 22.5 0L7.5 0ZM7.5 1.875H22.5C22.9973 1.875 23.4742 2.07254 23.8258 2.42417C24.1775 2.77581 24.375 3.25272 24.375 3.75V26.25C24.375 26.7473 24.1775 27.2242 23.8258 27.5758C23.4742 27.9275 22.9973 28.125 22.5 28.125H7.5C7.00272 28.125 6.52581 27.9275 6.17417 27.5758C5.82254 27.2242 5.625 26.7473 5.625 26.25V3.75C5.625 3.25272 5.82254 2.77581 6.17417 2.42417C6.52581 2.07254 7.00272 1.875 7.5 1.875Z"
                                    fill="#2795CF"
                                />
                                <path
                                    d="M8.62984 22.6638C8.26438 22.5177 7.96995 22.2353 7.80859 21.8763C7.44296 21.1488 7.56484 20.4213 7.95859 19.8101C8.32984 19.2345 8.94484 18.7451 9.64046 18.3345C10.5216 17.8347 11.453 17.4294 12.4192 17.1251C13.1696 15.7762 13.8346 14.3816 14.4105 12.9495C14.0662 12.1672 13.7962 11.3542 13.6042 10.5213C13.443 9.77134 13.3811 9.02884 13.518 8.39134C13.6586 7.72759 14.0317 7.13134 14.7367 6.84821C15.0967 6.70384 15.4867 6.62321 15.8655 6.70384C16.056 6.7444 16.2351 6.82685 16.3898 6.94522C16.5445 7.0636 16.6709 7.21492 16.7598 7.38821C16.9248 7.69571 16.9848 8.05571 16.998 8.39696C17.0111 8.74759 16.9755 9.13759 16.9098 9.54821C16.7523 10.5045 16.4036 11.6745 15.9348 12.912C16.4521 14.0182 17.0671 15.0762 17.7723 16.0732C18.6069 16.0073 19.4463 16.0388 20.2736 16.167C20.9561 16.2888 21.6498 16.5326 22.0736 17.0388C22.2986 17.3088 22.4355 17.6388 22.4486 18.0101C22.4617 18.3701 22.3605 18.7263 22.1898 19.0657C22.042 19.3802 21.8129 19.6495 21.5261 19.8457C21.2426 20.0306 20.9079 20.1212 20.5698 20.1045C19.9492 20.0782 19.3436 19.737 18.8205 19.3226C18.1844 18.7966 17.6112 18.1989 17.1123 17.5413C15.8444 17.6852 14.5914 17.9399 13.368 18.3026C12.807 19.2963 12.1668 20.2431 11.4536 21.1338C10.9098 21.7901 10.3136 22.362 9.71734 22.6095C9.37475 22.7644 8.98617 22.7839 8.62984 22.6638ZM11.2155 19.0995C10.9042 19.242 10.6155 19.392 10.3548 19.5457C9.73984 19.9095 9.34046 20.2638 9.14171 20.5713C8.96546 20.8432 8.96171 21.0401 9.06671 21.2482C9.08546 21.2895 9.10421 21.3157 9.11546 21.3307C9.13782 21.3247 9.15975 21.3172 9.18109 21.3082C9.43796 21.2032 9.84671 20.8676 10.3717 20.2357C10.6703 19.8701 10.9518 19.491 11.2155 19.0995ZM14.2905 16.6057C14.9165 16.4595 15.5483 16.3387 16.1842 16.2438C15.8427 15.7215 15.5236 15.1847 15.228 14.6351C14.9339 15.3 14.6213 15.9565 14.2905 16.6038V16.6057ZM18.8767 17.4495C19.158 17.7532 19.4317 18.012 19.6923 18.2182C20.1423 18.5745 20.4555 18.6926 20.6261 18.6982C20.6718 18.7042 20.7181 18.6943 20.7573 18.6701C20.8353 18.6085 20.8961 18.5277 20.9336 18.4357C21.0002 18.3215 21.0382 18.1928 21.0442 18.0607C21.0431 18.0167 21.0258 17.9746 20.9955 17.9426C20.898 17.8263 20.6205 17.6576 20.0242 17.5507C19.6449 17.4873 19.2612 17.4541 18.8767 17.4513V17.4495ZM15.1455 10.8757C15.3033 10.3667 15.4285 9.84814 15.5205 9.32321C15.5786 8.97071 15.6011 8.68009 15.5917 8.45134C15.5922 8.32513 15.572 8.1997 15.5317 8.08009C15.4379 8.0917 15.3463 8.11697 15.2598 8.15509C15.0967 8.22071 14.9636 8.35384 14.8923 8.68571C14.8173 9.04571 14.8361 9.56509 14.9786 10.227C15.0236 10.4351 15.0798 10.6526 15.1473 10.8757H15.1455Z"
                                    fill="#2795CF"
                                />
                            </g>
                            <defs>
                                <clipPath id="clip0_3654_183609">
                                    <rect width="30" height="30" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </span>
            <div class="">
              <h3 class="text-xl text-gray-700 font-medium">{{file.name}}</h3>
              <p class="text-sm text-gray-500 mt-1">{{fileSizeFormatter(file.size)}}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
      <div class="mt-5">
        <p class="text-red-500 text-sm py-2" v-if="errors?.file">{{errors.file}}</p>
        <p class="text-red-500 text-sm py-2" v-if="errors?.unique_id">{{errors.unique_id}}</p>
      </div>
  </div>
</template>

<script setup>
import { useDropzone } from "vue3-dropzone";
import { FwbProgress } from 'flowbite-vue'
import {onMounted, ref} from "vue";
import { uuid } from 'vue3-uuid';
import {router} from "@inertiajs/vue3";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const unique_id = ref(null)
const file = ref(null)
const uploaded = ref(0)

defineProps({ errors: Object })

function onDrop(acceptFiles, rejectReasons) {
  console.log(acceptFiles);
  console.log(rejectReasons);
  if (acceptFiles.length > 0){
    file.value = acceptFiles[0]
   router.post('/store',{
      file:file.value,
      unique_id:unique_id.value
    },{
      forceFormData: true,
      onProgress:(event)=>{
        uploaded.value = event.percentage
        console.log(event)
      }
    })
  }
}
onMounted(()=>{
  unique_id.value = uuid.v4()
  console.log(unique_id.value)
})
const { getRootProps, getInputProps,isDragActive} = useDropzone({ onDrop });

function fileSizeFormatter(size){
    var i = size === 0 ? 0 : Math.floor(Math.log(size) / Math.log(1024));
    return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
}

</script>