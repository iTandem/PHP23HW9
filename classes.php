<?php
    
    class Car // класс "Автомобиль"
    {
        const WHEEL_COUNT = 4; // константа - у автомобиля 4 колеса
        private $wheelCount = self::WHEEL_COUNT; // у автомобиля 4 колеса, которые можно ставить и снимать
        private $color = [255, 255, 255]; // автомобиль имеет цвет
        private $speed = 0; // автомобиль может двигаться, значит есть скорость
        
        private static $maxSpeed; // у автомобиля есть максимальная скорость с которой он может двигаться
        
        public function __construct($color)
        {
            $this->color = $color;
        }
        
        public function getWheelCount()
        {
            return $this->wheelCount;
        }
        
        public function getColor()
        {
            return $this->color;
        }
        
        public function getSpeed()
        {
            return $this->speed;
        }
        
        public function getMaxSpeed()
        {
            return self::$maxSpeed;
        }
        
        
        public function paint($r, $g, $b) // метод позволяет получить необходимый цвет
        {
            if (in_array($r, range(0, 255)) or
                in_array($g, range(0, 255)) or
                in_array($b, range(0, 255))) {
                echo 'Все компоненты цвета должны быть в диапазоне от 0 до 255' . PHP_EOL;
            } else {
                $this->color = [$r, $g, $b];
            }
        }
        
        public function takeOffWheels($wheelCount) // можем снять колёса, если они установлены, но не более 4х
        {
            if (!$this->wheelCount) {
                echo 'На машине не установлены колёса' . PHP_EOL;
            } elseif ($wheelCount > self::WHEEL_COUNT) {
                echo 'У машины не бывает столько колёс' . PHP_EOL;
            } elseif ($wheelCount > $this->wheelCount) {
                echo 'Вы пытаетесь снять колёс больше, чем установлено на машине. Установлено: ' . $this->wheelCount . PHP_EOL;
            } else {
                $this->wheelCount -= $wheelCount;
            }
        }
        
        public function takeOnWheels($wheelCount) // можем установить колёса, но не более 4х
        {
            if ($this->wheelCount == self::WHEEL_COUNT) {
                echo 'На машине установлены все колёса' . PHP_EOL;
            } elseif ($wheelCount + $this->wheelCount > self::WHEEL_COUNT) {
                echo 'Вы пытаетесь установить колёс больше, чем может быть в машине. Установлено: ' . $this->wheelCount . PHP_EOL;
            } else {
                $this->wheelCount += $wheelCount;
            }
        }
        
        public static function setMaxSpeed($speed) // можем установить максимальную скорость
        {
            self::$maxSpeed = $speed;
        }
    }
    
    
    class TvSet // класс "Телевизор"
    {
        private $serialNumber; // у телевизора есть серийный номер
        private $channels = ['Первый', 'Россия']; // телевизор может принимать каналы и это можно настроить
        private $powerOn = false; // у телевизора есть кнопка включения/выключения
        private $volume = 0; // у телевизора есть регулятор громкости
        private $currentChannel = 0; // у телевизора можно переключать каналы, которые мы настроили
        
        public function __construct($number)
        {
            $this->serialNumber = $number;
        }
        
        public function getChannels()
        {
            return $this->channels;
        }
        
        public function getPowerOn()
        {
            return $this->powerOn;
        }
        
        public function getVolume()
        {
            return $this->powerOn ? $this->volume : 0;
        }
        
        public function getCurrentChannel()
        {
            return $this->powerOn ? $this->currentChannel : null;
        }
        
        
        public function clickPower() // включаем телевизор
        {
            $this->powerOn = !$this->powerOn;
        }
        
        public function clickTune($channels) // если телевизор включен - настраиваем каналы
        {
            if ($this->powerOn) {
                $this->channels = array_merge($this->channels, $channels);
            }
        }
        
        public function clickVolumePlus($time) // если телевизор включен - регулируем громкость(прибавляем)
        {
            if ($this->powerOn) {
                $newVolume = $this->volume + $time;
                $this->volume = ($newVolume < 100) ? $newVolume : 100;
            }
        }
        
        public function clickVolumeMinus($time) // если телевизор включен - регулируем громкость(убавляем)
        {
            if ($this->powerOn) {
                $newVolume = $this->volume - $time;
                $this->volume = ($newVolume > 0) ? $newVolume : 0;
            }
        }
        
        public function clickChannelPlus() // если телевизор включен - переключаем на следующий канал
        {
            if ($this->powerOn) {
                if ($this->currentChannel == count($this->channels) - 1) {
                    $this->currentChannel = 0;
                } else {
                    $this->currentChannel += 1;
                }
            }
        }
        
        public function clickChannelMinus() // если телевизор включен - переключаем на предыдущий канал
        {
            if ($this->powerOn) {
                if ($this->currentChannel == 0) {
                    $this->currentChannel = count($this->channels) - 1;
                } else {
                    $this->currentChannel -= 1;
                }
            }
        }
    }
    
    
    class Pen  // класс - "Ручка"
    {
        const PT_INK_RATE = 0.01; // констаната расхода чернил для написания одной буквы или символа
        
        private $color; // у ручки есть цвет чернил
        private $inkLevel = 100; // у ручки есть уровень чернил и её можно заправить
        
        public function __construct($color = [0, 0, 255])
        {
            $this->color = $color;
        }
        
        public function getInkLevel()
        {
            return $this->inkLevel;
        }
        
        
        public function write($chars, $fontSize) // пишем ручкой текст
        {
            if ($this->inkLevel > 0) {
                $inkRate = self::PT_INK_RATE * $chars * $fontSize;
                
                if ($this->inkLevel > $inkRate) {
                    $this->inkLevel = round($this->inkLevel - $inkRate, 2); // округляем до целого числа
                } else {
                    $possibleChars = floor($this->inkLevel / self::PT_INK_RATE * $fontSize);
                    // если чернила закончились выводим сообщение:
                    echo "Невозможно написать $chars символов $fontSize-м шифтом оставшимся количеством чернил. Написано $possibleChars символов" . PHP_EOL;
                }
            }
        }
        
        public function recharge() // заправляем ручку
        {
            $this->inkLevel = 100;
        }
    }
    
    class Duck // класс "Утка"
    {
        private $color; // имеет цвет
        private $weight; // имеет вес
        
        public function __construct($color = [255, 255, 0], $weight = 100)
        {
            $this->color = $color;
            $this->weight = $weight;
        }
        
        public function getColor()
        {
            return $this->color;
        }
        
        public function getWeigth()
        {
            return $this->weight;
        }
        
        public function press() // "крякает" если нажать
        {
            echo "Quack!" . PHP_EOL;
        }
    }
    
    class Product // класс "Товар"
    {
        private $name; // название
        private $description; // описание
        private $category; // категория
        private $weight = 100; // вес
        private $price = 0; // цена
        private $discount = 0; // скидка
        
        public function __construct(
            $name,
            $weight,
            $price,
            $description = "",
            $category = "Uncategorized",
            $discount = 0)
        {
            $this->name = $name;
            $this->description = $description;
            $this->category = $category;
            
            $this->setWeight($weight);
            $this->setPrice($price);
            $this->setDiscount($discount);
        }
        
        public function getName()
        {
            return $this->name;
        }
        
        public function getDescription()
        {
            return $this->description;
        }
        
        public function getCategory()
        {
            return $this->category;
        }
        
        public function getWeight()
        {
            return $this->weight;
        }
        
        public function getPrice()
        {
            $price = round($this->price * (1 - 0.01 * ($this->discount)), 2);
            
            return $price;
        }
        
        public function getDiscount()
        {
            return $this->discount;
        }
        
        public function setDescription($description)
        {
            $this->description = $description;
        }
        
        public function setCategory($category)
        {
            $this->category = $category;
        }
        
        public function setPrice($price)
        {
            if ($price > 0) {
                $this->price = $price;
            } else {
                echo 'Цена не может быть отрицательной. Задана цена по умолчанию: ' . $this->price . PHP_EOL;
            }
        }
        
        public function setDiscount($discount)
        {
            if ($discount >= 0 and $discount < 100) {
                $this->discount = $discount;
            } else {
                echo 'Скидка может быть в пределах от 0 до 100 (не включительно). Задана скидка по умолчанию: ' . $this->discount . PHP_EOL;
            }
        }
        
        public function setWeight($weight)
        {
            if ($weight > 0) {
                $this->weight = $weight;
            } else {
                echo 'Вес не может быть отрицательным. Задан вес по умолчанию: ' . $this->weight . PHP_EOL;
            }
        }
    }
    
    
    $silverCar = new Car([192, 192, 192]);
    $siennaCar = new Car([160, 82, 45]);
    
    $tvSet1 = new TvSet('TV00001');
    $tvSet2 = new TvSet('TV00002');
    
    $bluePen = new Pen([0, 0, 255]);
    $greenPen = new Pen([0, 255, 0]);
    
    $standardYellowDuck = new Duck([255, 255, 0], 2000);
    $hugeCyanDuck = new Duck([0, 255, 255], 3000);
    
    $huawei = new Product('Huawei', 150, 19999, 'Great smart phone!.', 'Smart-phones', 0);
    $ps4Pro = new Product('Playstation 4 Pro', 3300, 29999, 'Greatness awaits.', 'Game consoles', 10);

