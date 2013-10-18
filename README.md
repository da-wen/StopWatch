StopWatch
=========

simple, not complex stopwatch.
Measure your applications based on time taken and memory usage.


Usage
=====

create an new Stopwatch object and add some laps:

```
use Dawen\Component\Stopwatch\StopWatch;

$_oStopwatch = new StopWatch();

$_oStopWatch->start();

//do something

$_oStopWatch->lap();

//do something else

$_oStopWatch->stop();
```

get duration and memory usage:

```
$_sDuration = $_oStopWatch->getDuration();

$_sMemoryUsage = $_oStopWatch->getMemoryUsage();

```