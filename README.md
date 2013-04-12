# Companion class generator for PHP

Generate and instantiate PHP companion objects.  Companion objects are genated
based on two inputs, a class definition and a companion object
template. Template documentation can be found on [the php-code-templates github
site](git@github.com:pgraham/php-code-templates.git)

## Example

Given a class template:

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

This library can generate and instantiate instances of this class.  All that is
required is to create a concrete generator class.

    <?php
    namespace my\ns;

    use \zpt\gen\ClassGenerator;

    /**
     * A class generator for model validators.
     */
    class ValidatorGenerator extends ClassGenerator {
        
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

