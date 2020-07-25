export default {
    APP_URL: process.env.MIX_APP_URL,
    APP_NAME: process.env.MIX_APP_NAME,
    LOCALE: process.env.MIX_LOCALE ? process.env.MIX_LOCALE : 'en',
    DISABLE_COOKBOOKS: process.env.MIX_DISABLE_COOKBOOKS == 'true',
    DISABLE_TAGS: process.env.MIX_DISABLE_TAGS == 'true',
}
