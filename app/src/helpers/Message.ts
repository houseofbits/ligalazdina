import axios, {AxiosInstance, AxiosResponse} from "axios";

interface MessageStructure {
    firstName: string;
    lastName: string;
    email: string;
    message: string;
}

class Message {

    axiosInstance: AxiosInstance;

    constructor() {
        this.axiosInstance = axios.create({
            baseURL: 'https://www.ligalazdina.com',
            withCredentials: false,
            headers: {
                'Content-type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
                'Cache-Control': 'no-cache',
                'Pragma': 'no-cache',
                'Expires': '0',
            }
        });
    }

    send(message: MessageStructure): Promise<AxiosResponse> {
        return this.axiosInstance.post('message.php', message);
    }
}

export default new Message();