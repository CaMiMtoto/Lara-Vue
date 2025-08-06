import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
import { App } from 'vue';

dayjs.extend(relativeTime);

declare module '@vue/runtime-core' {
    interface ComponentCustomProperties {
        $formatDate: (date: string | Date, format?: string) => string;
        $fromNow: (date: string | Date) => string;
    }
}

export default {
    install(app: App) {
        app.config.globalProperties.$formatDate = (date: string | Date, format = 'YYYY-MM-DD') => {
            return dayjs(date).format(format);
        };
        app.config.globalProperties.$fromNow = (date: string | Date) => {
            return dayjs(date).fromNow();
        };
    },
};
