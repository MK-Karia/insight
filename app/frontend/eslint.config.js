const {
    defineConfig,
} = require("eslint/config");

const tsParser = require("@typescript-eslint/parser");
const globals = require("globals");
const typescriptEslint = require("@typescript-eslint/eslint-plugin");
const react = require("eslint-plugin-react");
const prettier = require("eslint-plugin-prettier");
const js = require("@eslint/js");

const {
    FlatCompat,
} = require("@eslint/eslintrc");

const compat = new FlatCompat({
    baseDirectory: __dirname,
    recommendedConfig: js.configs.recommended,
    allConfig: js.configs.all
});

module.exports = defineConfig([{
    languageOptions: {
        parser: tsParser,
        ecmaVersion: 2021,
        sourceType: "module",

        parserOptions: {
            ecmaFeatures: {
                jsx: true,
            },
        },

        globals: {
            ...globals.browser,
            ...globals.node,
        },
    },

    settings: {
        react: {
            version: "detect",
        },
    },

    plugins: {
        "@typescript-eslint": typescriptEslint,
        react,
        prettier,
    },

    extends: compat.extends(
        "eslint:recommended",
        "plugin:react/recommended",
        "plugin:@typescript-eslint/recommended",
        "prettier",
    ),

    rules: {
        "semi": ["error", "never"],
        "comma-dangle": ["error", "always-multiline"],

        "indent": ["error", 4, {
            "SwitchCase": 1,
        }],

        "prettier/prettier": ["error", {
            semi: false,
            trailingComma: "all",
            tabWidth: 4,
            singleQuote: true,
            printWidth: 80,
        }],
    },
}]);
