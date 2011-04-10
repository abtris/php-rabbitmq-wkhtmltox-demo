<?php
/**
 * requires
 */
require_once APPLICATION_PATH . '/../library/php-amqplib/amqp.inc';
/**
 * Model
 */
class Application_Model_Rabbit
{
    /**
     * EXCHANGE
     */
    const EXCHANGE = 'wkhtmltox-exchange';
    /**
     * QUEUE
     */
    const QUEUE = 'wkhtmltox-queue';
    /**
     * CONSUMER
     */
    const CONSUMER_TAG = 'consumer';
    /**
     * Urls for procced
     * @var array
     */
    protected $urls = array();
    /**
     * @var array host, port, user, pass, vhost for RabbitMQ configuration
     */
    protected $options;
    /**
     * SetUp Options
     * @param  $options
     */
    public function __construct($options)
    {
        $this->options = $options->toArray();
    }
    /**
     * @param string $string
     * @return void
     */
    public function setUrl($string)
    {
        $this->urls = explode("\n", $string);
    }
    /**
     * Get Urls
     * @return array
     */
    public function getUrl()
    {
        return $this->urls;
    }
    /**
     * Consumer
     * @return void
     */
    public function consumer()
    {
        $conn = new AMQPConnection($this->options['host'],
                                   $this->options['port'],
                                   $this->options['user'],
                                   $this->options['pass'],
                                   $this->options['vhost']
        );

        $channel = $conn->channel();
        /**
         * $exchange, $type,$passive=false,$durable=false,$auto_delete=true,
         */
        $channel->exchange_declare(self::EXCHANGE, 'direct', false, true, false);
        $channel->queue_declare(self::QUEUE);
        $channel->queue_bind(self::QUEUE, self::EXCHANGE);

        $consumer = function($msg) {
          $msg->delivery_info['channel']->basic_cancel($msg->delivery_info['delivery_tag']);
          if ($msg->body == 'quit') {
              $msg->delivery_info['channel']->basic_cancel($msg->delivery_info['consumer_tag']);
          } else {
              // make PDF
              Application_Model_Wkhtmltopdf::proceed($msg->body, APPLICATION_PATH . '/../output/');
              // notify user
              system(`growlnotify -n "Rabbit demo" -m "PDF CREATED"`);
          }
        };

        $channel->basic_consume(self::QUEUE,
                                self::CONSUMER_TAG,
                                false,
                                false,
                                false,
                                false,
                                $consumer);
        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $conn->close();
    }
    /**
     * Producer
     * @param string $string
     * @return void
     */
    public function producer($string)
    {
        $conn = new AMQPConnection($this->options['host'],
                                   $this->options['port'],
                                   $this->options['user'],
                                   $this->options['pass'],
                                   $this->options['vhost']
        );
        $channel = $conn->channel();
        $channel->exchange_declare(self::EXCHANGE,
                                   'direct',
                                   false,
                                   true,
                                   false);
        $msg = new AMQPMessage($string, array('content-type' => 'text/plain'));
        $channel->basic_publish($msg, self::EXCHANGE);
        $channel->close();
        $conn->close();
    }
    /**
     * Run
     * @return void
     */
    public function run()
    {
        foreach ($this->urls as $url) {
            $this->producer(trim($url));
        }
    }

}