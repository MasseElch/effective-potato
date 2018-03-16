#!/bin/sh

# Workdir
mkdir -p .codegen

# Dump SwaggerSpec
docker run --rm -v ${PWD}:/app tico/swagger-php /app/api/src -o /app/.codegen/swagger.yaml

# Execute Swagger-Codegen
docker run --rm -v ${PWD}/.codegen:/local swaggerapi/swagger-codegen-cli generate -i /local/swagger.yaml -l typescript-angular -o /local/output/

for i in ${PWD}/.codegen/output/model/*.ts; do
    # Replace "ERRORUNKNOWN" with "any"
    sed -i '' -e 's/ERRORUNKNOWN/any/g' $i

    # Suffix every generated interface with "Interface", revert "DateInterface" to "Date"
    sed -i '' -E 's/( |\<)([A-Z][a-zA-Z]*) /\1\2Interface /g' $i
    sed -i '' -E 's/DateInterface/Date/g' $i
done

# Move the generated files to the models folder
mkdir -p ${PWD}/web/src/codegen
rm -rf ${PWD}/web/src/codegen/*
mv ${PWD}/.codegen/output/model/*.ts ${PWD}/web/src/codegen/

# Tidy up
rm -rf ${PWD}/.codegen
