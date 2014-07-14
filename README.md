# O-pal: Companion class generator for PHP

Generate and instantiate PHP companion objects.  Companion objects are genated
based on two inputs, a class definition and a companion object
template. Template documentation can be found on [the php-code-templates github
site](https://github.com/pgraham/php-code-templates)

## Example

Given a companion template (Validator.tmpl.php):

    <?php
    namespace my\dyn\ns;

    /**
     * Simple validator that ensures that there are no null properties.
     */
    class /*# modelName */Validator {

        /**
         * Validate the given model.
         *
         * @return true of all properties are non-null, false otherwise.
         */
        public function validate(/*# modelFq */ $model) {

            #{ each properties as prop
                if ($model->get/*# prop #/() === null) {
                    return false;
                }
            #}

            return true;
        }
    }

And a generator implementation:

    <?php
    namespace my\ns;

    use \zpt\gen\CompanionGenerator;

    /**
     * A class generator for model validators.
     */
    class ValidatorGenerator extends CompanionGenerator {

        public static $companionNs = 'my\dyn\ns';

        /**
         * @Override
         */
        public function getCompanionNamespace() {
            return self::$companionNs;
        }

        /**
         * @Override
         */
        public function getTemplatePath() {
            return __DIR__ . '/Validator.tmpl.php';
        }

        /**
         * @Override
         */
        public function getValues($className) {
            $values = array();

            $refClass = new ReflectionClass($className);
            $properties = array();
            foreach ($refClass->getMethods() as $method) {
              if (substr($method->getName(), 0, 3) === 'get') {
                  $properties[] = substr($method->getName(), 3));
              }
            }

            $values['properties'] = $properties;
            return $values;
        }
    }

A companion object for `SomeClass` can now be generated with the following:

    <?php
    $companionGenerator = new ValidatorGenerator($outputPath);
    $companionGenerator->generate('SomeClass');

They can be instantiated with the following (with `my\dyn\ns` added to an
autoloader):

    <?php
    $companionLoader = new CompanionLoader($outputPath);
    $validator = $companionLoader->get(
        ValidatorGenerator::$actorNamespace,
        'SomeClass'
    );

or

    <?php
    class ValidatorLoader extends CompanionLoader {

        public function loadFor($class) {
            return parent::get(ValidatorGenerator::$actorNs, 'SomeClass');
        }
    }

    (new ValidatorLoader)->loadFor('SomeClass');
