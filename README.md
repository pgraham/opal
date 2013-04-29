# O-pal: Companion class generator for PHP

Generate and instantiate PHP companion objects.  Companion objects are genated
based on two inputs, a class definition and a companion object
template. Template documentation can be found on [the php-code-templates github
site](git@github.com:pgraham/php-code-templates.git)

## Example

Given a companion template:

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

        /**
         * This is required by the base class.
         */
        public static $actorNamespace = 'my\dyn\ns';

        /**
         * @Override
         */
        public function getTemplatePath() {
            return __DIR__ . '/ModelValidator.tmpl.php';
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

Companion object can now be generated with the following:

    // TODO

They can be instantiated with the following:

    // TODO

## Why?

Companion objects, in order to be generic enough to be a useful abstraction,
will often require Reflection. Reflection can be quite slow so being able to
generate companion objects during a compile step can eliminate the need to use
reflection at runtime.
