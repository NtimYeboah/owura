import { PhpFunction } from '@bref.sh/constructs';
import * as cdk from 'aws-cdk-lib';
import { Construct } from 'constructs';
import * as targets from 'aws-cdk-lib/aws-events-targets';
import * as events from 'aws-cdk-lib/aws-events';

export class OwuraStack extends cdk.Stack {
  constructor(scope: Construct, id: string, props?: cdk.StackProps) {
    super(scope, id, props);

    const owuraFunction = new PhpFunction(this, 'Owura', {
      phpVersion: '8.2',
      handler: 'app/index.php',
      environment: {
        SLACK_BOT_USER_TOKEN: process.env.SLACK_BOT_USER_TOKEN!,
        SLACK_CHANNEL: process.env.SLACK_CHANNEL!
      }
    });
    
    const eventPattern = {
      "source": ["aws.ec2"],
      "detail-type": ["AWS API Call via CloudTrail"],
      "detail": {
        "eventSource": ["ec2.amazonaws.com"],
        "eventName": ["StopInstances"]
      }
    };

    const cloudTrailApiEventPattern = new events.Rule(this, 'OwuraManagementEventsRule', {
      eventPattern: eventPattern
    });

    cloudTrailApiEventPattern.addTarget(new targets.LambdaFunction(owuraFunction));
  }
}
