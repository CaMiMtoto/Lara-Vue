<script setup lang="ts">
import { Flash } from '@/types/flash';
import { CircleAlertIcon, CircleCheckBigIcon } from 'lucide-vue-next';

defineProps<{
    flash: Flash;
}>();
</script>

<template>
    <div>
        <div v-if="flash.success" class="mb-2 flex items-center justify-between rounded-sm bg-green-500 p-3 text-white">
            <div class="flex items-center gap-1">
                <div>
                    <CircleCheckBigIcon class="h-5 w-5" aria-hidden="true" />
                </div>
                <div>
                    {{ flash.success }}
                </div>
            </div>
            <!--            <div>
                            <XIcon class="h-5 w-5 cursor-pointer text-white" aria-hidden="true" />
                        </div>-->
        </div>
        <div v-if="flash.error" class="mb-2 flex items-center justify-between rounded-sm bg-red-500 p-3 text-white">
            <div class="flex items-center gap-1">
                <div>
                    <CircleAlertIcon class="h-5 w-5" aria-hidden="true" />
                </div>
                <div>
                    {{ flash.error }}
                </div>
            </div>
        </div>

        <div v-if="flash.info" class="mb-2 flex items-center justify-between rounded-sm bg-blue-500 p-3 text-white">
            <div class="flex items-center gap-1">
                <div>
                    <CircleAlertIcon class="h-5 w-5" aria-hidden="true" />
                </div>
                <div>
                    {{ flash.info }}
                </div>
            </div>
        </div>

        <div v-if="flash.warning" class="mb-2 flex items-center justify-between rounded-sm bg-yellow-500 p-3 text-white">
            <div class="flex items-center gap-1">
                <div>
                    <CircleAlertIcon class="h-5 w-5" aria-hidden="true" />
                </div>
                <div>
                    {{ flash.warning }}
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
