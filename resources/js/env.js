export default {
    APP_URL: process.env.MIX_APP_URL,
    APP_NAME: process.env.MIX_APP_NAME,
    DISABLE_COOKBOOKS: process.env.MIX_DISABLE_COOKBOOKS == 'true',
    DISABLE_TAGS: process.env.MIX_DISABLE_TAGS == 'true',
}
