export default {
    APP_URL: process.env.MIX_APP_URL,
    APP_NAME: process.env.MIX_APP_NAME,
    LOCALE: process.env.MIX_LOCALE,
    LOCALES: process.env.MIX_LOCALES.split(','),
    DISABLE_REGISTRATION: process.env.MIX_DISABLE_REGISTRATION == 'true',
    DISABLE_COOKBOOKS: process.env.MIX_DISABLE_COOKBOOKS == 'true',
    DISABLE_TAGS: process.env.MIX_DISABLE_TAGS == 'true',
    DISABLE_RATINGS: process.env.DISABLE_RATINGS == 'true',
    PREFER_PAGINATION: process.env.MIX_PREFER_PAGINATION == 'true',
    MAX_RATING_STARS: process.env.MIX_MAX_RATING_STARS,
    PLACEHOLDER_IMAGE: process.env.MIX_PLACEHOLDER_IMAGE,
    LOGO: process.env.MIX_LOGO,
    NOT_FOUND_IMAGE: process.env.MIX_NOT_FOUND_IMAGE
}
