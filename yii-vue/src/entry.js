import createApp from './main';
import renderToString from 'vue-server-renderer/basic'
const app = createApp();
if(typeof window === 'undefined')
{
    renderToString(app, (err, html) => {
        if(err)
        {
            throw new Error(err);
        }
        print(html)
    });
}